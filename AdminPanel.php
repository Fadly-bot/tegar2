<?php 
    include "service/sambungan.php";
    $query = mysqli_query($db, "SELECT * FROM pesanan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPanel</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
        <div id="hero" class="bg-light p-5 rounded-3 mb-4 mt-3 shadow-sm border">
            <div class="container-fluid py-4 text-center">
                <h1 class="display-4 fw-bold text-primary">Selamat Datang di Admin Panel</h1>
                <p class="col-md-8 fs-5 mx-auto text-muted">
                Selamat Datang di Platform Panel Admin. Kami menyediakan 
                beberapa informasi dan data tentang siapa saja yang memesan produk kami secara 
                efisien, aman, dan berkelanjutan.
                </p>
                

            </div>
        </div>
<h2 class="fw-bold mb-4 text-black ">Tabel Pemesanan</h2> 
    <div class="container py-1">
<table class="table table-dark rounded-3">
  <thead>
    <tr>
      <th scope="col">Nomor</th>
      <th scope="col">Nama</th>
      <th scope="col">Alamat Email</th>
      <th scope="col">Pesanan</th>
    </tr>
  </thead>
  
  <tbody>
    <?php 
    $no=1;
    while ($data = mysqli_fetch_array($query)) {
    echo "<tr>";
       echo "<td> ".$no." </td>";
       echo "<td> ".$data ['Username']. " </td>";
       echo "<td> ".$data ['Email']. "</td>";
       echo "<td> ".$data ['Pesanan']. "</td>";
     echo "</tr>";
     $no++;
    }
    
    
    ?>
    
  </tbody>
</table>
</div>

<script src="asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>