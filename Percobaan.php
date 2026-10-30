<?php include "service/database.php"?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menampilkan Data Database ke Tabel Web</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-family: sans-serif; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Daftar Data dari Database</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 2. Ambil data dari tabel database
            
            $no = 1;
            $query = mysqli_query($db, "SELECT * FROM users (Nama,Password));
            
            
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row[Nama]; ?></td>
                <td><?= $row[Password]; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>