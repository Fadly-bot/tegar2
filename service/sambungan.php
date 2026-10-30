<?php
/**
 * sambungan.php
 * Koneksi database dengan fallback otomatis:
 * - Jika MySQL aktif: terhubung ke database `kik`
 * - Jika MySQL belum aktif / offline: beralih otomatis ke Demo Data Store (JSON) tanpa crash
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hostname = "localhost";
$nama = "root";
$pw = "";
$database_name = "kik";

$is_demo_mode = false;
$db = null;

mysqli_report(MYSQLI_REPORT_OFF);

try {
    $db = @mysqli_connect($hostname, $nama, $pw, $database_name);
    if ($db) {
        $is_demo_mode = false;
        // Pastikan tabel pesanan memiliki kolom modern jika belum ada
        @mysqli_query($db, "CREATE TABLE IF NOT EXISTS `pesanan` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `Username` varchar(100) NOT NULL,
            `Email` varchar(100) NOT NULL,
            `WA` varchar(50) DEFAULT '',
            `Paket` varchar(150) DEFAULT 'Tier 1: Murid // Quick Reels',
            `Harga` varchar(50) DEFAULT 'Rp 45.000',
            `LinkDrive` text DEFAULT '',
            `Pesanan` text NOT NULL,
            `Status` varchar(50) DEFAULT 'Antrean',
            `Create_At` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Periksa kolom tambahan jika tabel sudah ada dari skema lama
        $col_check = @mysqli_query($db, "SHOW COLUMNS FROM `pesanan` LIKE 'Paket'");
        if ($col_check && mysqli_num_rows($col_check) == 0) {
            @mysqli_query($db, "ALTER TABLE `pesanan` ADD `WA` varchar(50) DEFAULT '' AFTER `Email`");
            @mysqli_query($db, "ALTER TABLE `pesanan` ADD `Paket` varchar(150) DEFAULT 'Tier 1: Murid // Quick Reels' AFTER `WA`");
            @mysqli_query($db, "ALTER TABLE `pesanan` ADD `Harga` varchar(50) DEFAULT 'Rp 45.000' AFTER `Paket`");
            @mysqli_query($db, "ALTER TABLE `pesanan` ADD `LinkDrive` text DEFAULT '' AFTER `Harga`");
            @mysqli_query($db, "ALTER TABLE `pesanan` ADD `Status` varchar(50) DEFAULT 'Antrean' AFTER `Pesanan`");
        }

        @mysqli_query($db, "CREATE TABLE IF NOT EXISTS `tlogin` (
            `Nama` varchar(50) NOT NULL,
            `Password` varchar(50) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        @mysqli_query($db, "CREATE TABLE IF NOT EXISTS `tregistrasi` (
            `Id` int(11) NOT NULL AUTO_INCREMENT,
            `Nama` varchar(50) NOT NULL,
            `Password` varchar(50) NOT NULL,
            `Email` varchar(50) NOT NULL,
            `WA` varchar(50) NOT NULL,
            `Role` varchar(20) DEFAULT 'user',
            PRIMARY KEY (`Id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Seed default user 'a' dan 'admin' ke MySQL jika belum ada
        $user_check = @mysqli_query($db, "SELECT * FROM tlogin WHERE Nama='a'");
        if ($user_check && mysqli_num_rows($user_check) == 0) {
            @mysqli_query($db, "INSERT INTO tlogin (Nama, Password) VALUES ('a', 'a'), ('admin', 'admin')");
        }
    } else {
        $is_demo_mode = true;
    }
} catch (Throwable $e) {
    $is_demo_mode = true;
    $db = null;
}

// Path ke JSON data fallback
$json_db_path = __DIR__ . '/../database/kik_data.json';

function read_json_data() {
    global $json_db_path;
    if (!file_exists($json_db_path)) {
        return ['users' => [], 'orders' => []];
    }
    $content = file_get_contents($json_db_path);
    return json_decode($content, true) ?: ['users' => [], 'orders' => []];
}

function write_json_data($data) {
    global $json_db_path;
    file_put_contents($json_db_path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Autentikasi Pengguna
 * Sesuai permintaan spesifik:
 * user = "a"; pass = "a" -> Masuk menu!
 */
function authenticate_user($username, $password) {
    global $db, $is_demo_mode;

    $username = trim($username);
    $password = trim($password);

    // 1. Cek spesifik akun 'a' / 'a' (sesuai request soal nomor 8)
    if ($username === "a" && $password === "a") {
        return [
            'success' => true,
            'user' => [
                'Nama' => 'a',
                'Email' => 'a@student.id',
                'WA' => '081234567890',
                'Role' => 'user'
            ]
        ];
    }

    // 2. Akun admin bawaan
    if ($username === "admin" && $password === "admin") {
        return [
            'success' => true,
            'user' => [
                'Nama' => 'admin',
                'Email' => 'admin@cutpixel.id',
                'WA' => '0882000291923',
                'Role' => 'admin'
            ]
        ];
    }

    // 3. Cek di MySQL jika terhubung
    if (!$is_demo_mode && $db) {
        $u = mysqli_real_escape_string($db, $username);
        $p = mysqli_real_escape_string($db, $password);

        // Cek di tlogin atau tregistrasi
        $res = @mysqli_query($db, "SELECT * FROM tregistrasi WHERE Nama='$u' AND Password='$p'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return ['success' => true, 'user' => $row];
        }

        $res2 = @mysqli_query($db, "SELECT * FROM tlogin WHERE Nama='$u' AND Password='$p'");
        if ($res2 && mysqli_num_rows($res2) > 0) {
            $row2 = mysqli_fetch_assoc($res2);
            return [
                'success' => true,
                'user' => [
                    'Nama' => $row2['Nama'],
                    'Email' => $row2['Nama'] . '@user.id',
                    'WA' => '',
                    'Role' => ($row2['Nama'] === 'admin' ? 'admin' : 'user')
                ]
            ];
        }
    }

    // 4. Cek di JSON fallback
    $data = read_json_data();
    foreach ($data['users'] as $u) {
        if ($u['Nama'] === $username && $u['Password'] === $password) {
            return ['success' => true, 'user' => $u];
        }
    }

    return ['success' => false, 'message' => 'Username atau Password anda salah'];
}

/**
 * Register User Baru
 */
function register_user($nama, $password, $email, $wa, $role = 'user') {
    global $db, $is_demo_mode;

    $nama = trim($nama);
    $password = trim($password);
    $email = trim($email);
    $wa = trim($wa);

    // Simpan ke MySQL jika online
    if (!$is_demo_mode && $db) {
        $n = mysqli_real_escape_string($db, $nama);
        $p = mysqli_real_escape_string($db, $password);
        $e = mysqli_real_escape_string($db, $email);
        $w = mysqli_real_escape_string($db, $wa);
        $r = mysqli_real_escape_string($db, $role);

        @mysqli_query($db, "INSERT INTO tregistrasi (Nama, Password, Email, WA, Role) VALUES ('$n', '$p', '$e', '$w', '$r')");
        @mysqli_query($db, "INSERT INTO tlogin (Nama, Password) VALUES ('$n', '$p')");
    }

    // Selalu sinkronkan juga ke JSON store
    $data = read_json_data();
    // Cek apakah username sudah ada
    foreach ($data['users'] as $u) {
        if ($u['Nama'] === $nama) {
            return ['success' => false, 'message' => 'Username sudah terdaftar, silakan gunakan username lain.'];
        }
    }

    $newUser = [
        'Nama' => $nama,
        'Password' => $password,
        'Email' => $email,
        'WA' => $wa,
        'Role' => $role
    ];
    $data['users'][] = $newUser;
    write_json_data($data);

    return ['success' => true, 'user' => $newUser];
}

/**
 * Ambil semua pesanan (untuk Admin Panel)
 */
function get_all_orders() {
    global $db, $is_demo_mode;

    if (!$is_demo_mode && $db) {
        $res = @mysqli_query($db, "SELECT * FROM pesanan ORDER BY ID DESC");
        if ($res) {
            $orders = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $orders[] = $row;
            }
            if (!empty($orders)) {
                return $orders;
            }
        }
    }

    // Fallback JSON
    $data = read_json_data();
    $orders = $data['orders'] ?? [];
    usort($orders, function($a, $b) {
        return ($b['ID'] ?? 0) - ($a['ID'] ?? 0);
    });
    return $orders;
}

/**
 * Ambil pesanan milik user tertentu (untuk PesananSaya.php)
 */
function get_user_orders($username, $email = '') {
    $all = get_all_orders();
    $result = [];
    foreach ($all as $item) {
        $itemUser = $item['Username'] ?? '';
        $itemEmail = $item['Email'] ?? '';
        if (strcasecmp($itemUser, $username) === 0 || (!empty($email) && strcasecmp($itemEmail, $email) === 0)) {
            $result[] = $item;
        }
    }
    return $result;
}

/**
 * Simpan pesanan baru
 */
function save_new_order($username, $email, $wa, $paket, $harga, $linkDrive, $pesanan) {
    global $db, $is_demo_mode;

    $now = date('Y-m-d H:i:s');
    $status = 'Antrean';

    $inserted_id = null;

    if (!$is_demo_mode && $db) {
        $u = mysqli_real_escape_string($db, $username);
        $e = mysqli_real_escape_string($db, $email);
        $w = mysqli_real_escape_string($db, $wa);
        $p = mysqli_real_escape_string($db, $paket);
        $h = mysqli_real_escape_string($db, $harga);
        $l = mysqli_real_escape_string($db, $linkDrive);
        $msg = mysqli_real_escape_string($db, $pesanan);

        $sql = "INSERT INTO pesanan (Username, Email, WA, Paket, Harga, LinkDrive, Pesanan, Status, Create_At) 
                VALUES ('$u', '$e', '$w', '$p', '$h', '$l', '$msg', '$status', '$now')";
        if (@mysqli_query($db, $sql)) {
            $inserted_id = mysqli_insert_id($db);
        }
    }

    // Sinkronkan ke JSON store
    $data = read_json_data();
    $newId = $inserted_id ?: (count($data['orders']) > 0 ? max(array_column($data['orders'], 'ID')) + 1 : 1);

    $newOrder = [
        'ID' => (int)$newId,
        'Username' => $username,
        'Email' => $email,
        'WA' => $wa,
        'Paket' => $paket,
        'Harga' => $harga,
        'LinkDrive' => $linkDrive,
        'Pesanan' => $pesanan,
        'Status' => $status,
        'Create_At' => $now
    ];

    $data['orders'][] = $newOrder;
    write_json_data($data);

    return $newOrder;
}

/**
 * Update Status Pesanan (untuk Admin)
 */
function update_order_status($id, $new_status) {
    global $db, $is_demo_mode;

    if (!$is_demo_mode && $db) {
        $id = (int)$id;
        $s = mysqli_real_escape_string($db, $new_status);
        @mysqli_query($db, "UPDATE pesanan SET Status='$s' WHERE ID=$id");
    }

    $data = read_json_data();
    foreach ($data['orders'] as &$order) {
        if (($order['ID'] ?? 0) == $id) {
            $order['Status'] = $new_status;
            break;
        }
    }
    write_json_data($data);
    return true;
}

/**
 * Hapus Pesanan (untuk Admin)
 */
function delete_order($id) {
    global $db, $is_demo_mode;

    if (!$is_demo_mode && $db) {
        $id = (int)$id;
        @mysqli_query($db, "DELETE FROM pesanan WHERE ID=$id");
    }

    $data = read_json_data();
    $data['orders'] = array_values(array_filter($data['orders'], function($o) use ($id) {
        return ($o['ID'] ?? 0) != $id;
    }));
    write_json_data($data);
    return true;
}
