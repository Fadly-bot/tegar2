<?php
if (isset($_POST["Kirim"])) {
    $Username = $_POST["Username"];
    $Email = $_POST["Email"];
    $Pesanan = $_POST["Pesanan"];
    if (empty($Username) || empty($Email) || empty($Pesanan)) {
        include "alertsgagal.php";
    } else {
        include "alerts.php";
        include "service/sambungan.php";
        $mysql = "INSERT INTO pesanan (Username,Email,Pesanan) VALUES ('$Username', '$Email', '$Pesanan')";
        mysqli_query($db, $mysql);
    }
}
?>

<style>
    .pemesanan-section {
        color: #f8fafc;
        font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        background:
            linear-gradient(120deg, rgba(4, 10, 24, 0.82), rgba(4, 12, 30, 0.72)),
            url("Layout/backgroundpesan.jpg") center / cover no-repeat;
    }

    .pemesanan-card {
        background: rgba(8, 15, 30, 0.88);
        color: #f8fafc;
        border: 1px solid rgba(148, 163, 184, 0.28);
        backdrop-filter: blur(8px);
    }

    .pemesanan-card .form-control {
        color: #f8fafc;
        background-color: rgba(15, 23, 42, 0.85);
        border-color: rgba(148, 163, 184, 0.35);
    }

    .pemesanan-card .form-control::placeholder {
        color: #94a3b8;
    }
</style>

<section id="kontak" class="pemesanan-section py-5">
    <div class="container-fluid px-4 px-lg-5 py-lg-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 text-center text-lg-start">
                <h2 class="display-5 fw-bold mb-3">Hubungi Kami</h2>
                <p class="fs-5 text-white-50 mb-4">Punya ide atau butuh bantuan? Hubungi kami melalui informasi berikut.</p>
                <p class="fs-5 mb-2">nickeld@gmail.com</p>
                <p class="fs-5 mb-2">+62-6767-0902-111</p>
                <p class="fs-5 mb-0">Indonesia</p>
            </div>

            <div class="col-lg-7">
                <form action="KIKT.php" method="POST">
                    <div class="pemesanan-card shadow-lg rounded-4 p-4 p-lg-5">
                        <h3 class="text-center fw-bold mb-4">Kirim Pesanan</h3>
                        <div class="mb-3">
                            <label class="form-label" for="nama-pemesan">Nama Lengkap</label>
                            <input id="nama-pemesan" type="text" class="form-control" placeholder="Masukkan nama Anda" name="Username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email-pemesan">Alamat Email</label>
                            <input id="email-pemesan" type="email" class="form-control" placeholder="nama@email.com" name="Email">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="pesanan">Pesanan</label>
                            <textarea id="pesanan" class="form-control" rows="4" name="Pesanan"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary w-100 py-2" data-bs-toggle="modal" data-bs-target="#modalKirim">✈ Kirim Pesanan</button>
                    </div>

                    <div class="modal fade" id="modalKirim" tabindex="-1" aria-labelledby="modalKirimLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalKirimLabel">Konfirmasi Pengiriman</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0">Apakah Anda yakin data yang diisikan pada formulir sudah benar?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" name="Kirim">Ya, Kirim Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>