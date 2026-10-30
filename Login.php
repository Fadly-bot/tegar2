<?php
require_once "service/sambungan.php";

$message = "";
$message_type = "";
$redirect = false;

if (isset($_POST['Login'])) {
    // Tangkap input (mendukung txtuser/txtpass dan Username/Password)
    $txtuser = trim($_POST['txtuser'] ?? $_POST['Username'] ?? '');
    $txtpass = trim($_POST['txtpass'] ?? $_POST['Password'] ?? '');

    // Sesuai kode referensi user:
    // user = "a"; pass = "a";
    // if (txtuser.Text == "a" && txtpass.Text == "a") { MessageBox.Show("Masuk menu"); ... }
    if ($txtuser === "a" && $txtpass === "a") {
        $_SESSION["username"] = "a";
        $_SESSION["nama_lengkap"] = "Fadly (Demo User)";
        $_SESSION["email"] = "a@student.id";
        $_SESSION["role"] = "user";
        $_SESSION["is_login"] = true;

        $message = "Masuk menu";
        $message_type = "success";
        $redirect = "index.php";
    } else {
        // Cek login via database (termasuk admin dan user terdaftar)
        $auth = authenticate_user($txtuser, $txtpass);
        if ($auth['success']) {
            $userData = $auth['user'];
            $_SESSION["username"] = $userData['Nama'];
            $_SESSION["nama_lengkap"] = $userData['Nama'];
            $_SESSION["email"] = $userData['Email'] ?? ($userData['Nama'] . '@user.id');
            $_SESSION["role"] = $userData['Role'] ?? 'user';
            $_SESSION["is_login"] = true;

            $message = "Masuk menu";
            $message_type = "success";
            $redirect = ($_SESSION["role"] === 'admin') ? "AdminPanel.php" : "index.php";
        } else {
            // Sesuai kode referensi user: MessageBox.Show("Username atau Password anda salah");
            $message = "Username atau Password anda salah";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login // NIQUEL CUT.PIXEL Studio</title>
    <!-- Google Fonts: Space Grotesk & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'paper': '#FCF9F2',
                        'cyber-yellow': '#FFE500',
                        'mint': '#00F0A8',
                        'coral': '#FF3366',
                        'ink': '#000000',
                    },
                    fontFamily: {
                        'grotesk': ['"Space Grotesk"', 'sans-serif'],
                        'mono': ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        .retro-grid-bg {
            background-color: #FCF9F2;
            background-size: 24px 24px;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
        }
        .btn-brutal {
            transition: transform 0.08s ease, box-shadow 0.08s ease;
        }
        .btn-brutal:hover {
            transform: translate(-1px, -1px);
            box-shadow: 5px 5px 0px #000000;
        }
        .btn-brutal:active {
            transform: translate(3px, 3px);
            box-shadow: 0px 0px 0px #000000 !important;
        }
    </style>
</head>
<body class="retro-grid-bg text-ink font-grotesk min-h-screen flex flex-col justify-between selection:bg-cyber-yellow">

    <!-- Top Mini Bar -->
    <header class="w-full bg-paper border-b-[3px] border-ink px-4 py-3 flex justify-between items-center shadow-[0_3px_0px_#000]">
        <a href="index.php" class="flex items-center gap-2 group">
            <div class="w-8 h-8 bg-cyber-yellow border-2 border-ink flex items-center justify-center font-mono font-bold text-lg shadow-[2px_2px_0px_#000] group-hover:rotate-6 transition-transform">
                ✂️
            </div>
            <span class="font-bold text-lg tracking-tight uppercase">NIQUEL // CUT.PIXEL</span>
        </a>
        <a href="index.php" class="font-mono text-xs font-bold uppercase px-3 py-1 bg-white border-2 border-ink shadow-[2px_2px_0px_#000] hover:bg-mint transition-colors">
            ← Kembali ke Beranda
        </a>
    </header>

    <!-- Main Login Area -->
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white border-[3px] border-ink shadow-[8px_8px_0px_#000000] relative">
            
            <!-- Window Header Strip (Retro OS Style) -->
            <div class="bg-ink text-white px-4 py-2.5 flex items-center justify-between border-b-[3px] border-ink">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-coral border border-white inline-block"></span>
                    <span class="w-3 h-3 bg-cyber-yellow border border-white inline-block"></span>
                    <span class="w-3 h-3 bg-mint border border-white inline-block"></span>
                    <span class="font-mono text-xs font-bold tracking-wider uppercase ml-1">AUTH_GATEWAY // V2.6</span>
                </div>
                <span class="font-mono text-xs text-cyber-yellow font-bold">[LOGIN]</span>
            </div>

            <!-- Login Content -->
            <div class="p-6 md:p-8">

                <!-- Alert Message Box (Sesuai MessageBox.Show di Windows Forms) -->
                <?php if (!empty($message)): ?>
                    <div id="messageBoxModal" class="mb-6 p-4 border-[3px] border-ink shadow-[4px_4px_0px_#000] <?= $message_type === 'success' ? 'bg-mint' : 'bg-coral text-white' ?>">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl"><?= $message_type === 'success' ? '🚀' : '⚠️' ?></span>
                            <div>
                                <h4 class="font-bold text-sm uppercase font-mono tracking-wider">
                                    <?= $message_type === 'success' ? 'MESSAGE BOX: SUCCESS' : 'MESSAGE BOX: ERROR' ?>
                                </h4>
                                <p class="text-base font-bold mt-1"><?= htmlspecialchars($message) ?></p>
                                <?php if ($redirect): ?>
                                    <p class="text-xs font-mono mt-1 opacity-90">Mengarahkan ke menu dalam 1.5 detik...</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($redirect): ?>
                        <script>
                            setTimeout(function() {
                                window.location.href = "<?= $redirect ?>";
                            }, 1400);
                        </script>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (isset($_GET['logout'])): ?>
                    <div class="mb-6 p-3 bg-paper border-2 border-ink shadow-[3px_3px_0px_#000] font-mono text-xs font-bold text-center">
                        ✅ Anda telah berhasil logout dari sistem.
                    </div>
                <?php endif; ?>

                <div class="text-center mb-6">
                    <span class="inline-block px-2.5 py-1 bg-cyber-yellow text-ink border-2 border-ink shadow-[2px_2px_0px_#000] font-mono text-xs font-bold uppercase mb-2">
                        STUDENT & CREATOR ACCESS
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold uppercase tracking-tight">
                        Masuk ke Akun Anda
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Akses riwayat pesanan video, pantau antrean, & checkout instan.
                    </p>
                </div>

                <!-- Form Login -->
                <form action="Login.php" method="POST" class="space-y-4">
                    
                    <div>
                        <label class="block font-mono text-xs font-bold uppercase tracking-wider mb-1.5" for="txtuser">
                            Username / ID Akun:
                        </label>
                        <input 
                            type="text" 
                            id="txtuser" 
                            name="txtuser" 
                            required 
                            placeholder="Ketik 'a' atau username anda" 
                            class="w-full px-3.5 py-2.5 bg-paper border-[2px] border-ink shadow-[3px_3px_0px_#000] font-mono text-sm focus:outline-none focus:bg-white focus:shadow-[4px_4px_0px_#FFE500] transition-all"
                            value="<?= isset($_POST['txtuser']) ? htmlspecialchars($_POST['txtuser']) : (isset($_GET['user']) ? htmlspecialchars($_GET['user']) : '') ?>"
                        >
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="font-mono text-xs font-bold uppercase tracking-wider" for="txtpass">
                                Password:
                            </label>
                            <span class="font-mono text-[11px] text-gray-500 font-bold">(Demo: a)</span>
                        </div>
                        <input 
                            type="password" 
                            id="txtpass" 
                            name="txtpass" 
                            required 
                            placeholder="Ketik 'a' atau password anda" 
                            class="w-full px-3.5 py-2.5 bg-paper border-[2px] border-ink shadow-[3px_3px_0px_#000] font-mono text-sm focus:outline-none focus:bg-white focus:shadow-[4px_4px_0px_#FFE500] transition-all"
                        >
                    </div>

                    <!-- Tombol Login -->
                    <button 
                        type="submit" 
                        name="Login" 
                        class="btn-brutal w-full py-3.5 bg-cyber-yellow text-ink border-[3px] border-ink shadow-[4px_4px_0px_#000] font-bold text-base uppercase tracking-wider mt-2 flex items-center justify-center gap-2"
                    >
                        <span>LOGIN KE MENU SEKARANG</span>
                        <span>⚡</span>
                    </button>
                </form>

                <!-- Quick Demo Credentials Box -->
                <div class="mt-6 pt-5 border-t-2 border-dashed border-gray-300">
                    <p class="font-mono text-xs font-bold uppercase text-gray-500 text-center mb-2.5">
                        ⚡ SHORTCUT DEMO CEPAT (1-KLIK)
                    </p>
                    <div class="grid grid-cols-2 gap-2">
                        <button 
                            type="button" 
                            onclick="fillDemo('a', 'a')" 
                            class="px-2.5 py-2 bg-paper border-2 border-ink shadow-[2px_2px_0px_#000] hover:bg-cyber-yellow font-mono text-xs font-bold text-left transition-colors"
                        >
                            👤 User: <strong>a</strong><br>
                            🔑 Pass: <strong>a</strong>
                        </button>
                        <button 
                            type="button" 
                            onclick="fillDemo('admin', 'admin')" 
                            class="px-2.5 py-2 bg-paper border-2 border-ink shadow-[2px_2px_0px_#000] hover:bg-mint font-mono text-xs font-bold text-left transition-colors"
                        >
                            🛡️ Admin: <strong>admin</strong><br>
                            🔑 Pass: <strong>admin</strong>
                        </button>
                    </div>
                </div>

                <!-- Footer Nav to Register -->
                <div class="mt-6 text-center text-sm font-medium">
                    Belum punya akun murid / kreator? 
                    <a href="Register.php" class="font-bold underline decoration-2 hover:bg-cyber-yellow px-1 transition-colors">
                        Daftar Akun Baru →
                    </a>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer Strip -->
    <footer class="w-full bg-ink text-white py-3 px-4 text-center font-mono text-xs border-t-[3px] border-ink">
        &copy; 2026 NIQUEL // CUT.PIXEL STUDIO • ZERO AI SLOP • 100% HUMAN CRAFTED
    </footer>

    <script>
        function fillDemo(user, pass) {
            document.getElementById('txtuser').value = user;
            document.getElementById('txtpass').value = pass;
            // Highlight effect
            document.getElementById('txtuser').focus();
        }
    </script>
</body>
</html>
