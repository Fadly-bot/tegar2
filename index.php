<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niquel</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <!-- Menu -->
    <?php include "Layout/Menu.php" ?>

    <!-- About Us-->
    <?php include "Layout/AboutUs.php" ?>

    <!-- Slide-->
    <?php include "Layout/Carousel.php" ?>

    <?php include "Layout/question.php" ?>
    <!-- Card -->
    <?php include "Layout/Card.php" ?>
    <!-- Kontak-->
    <?php include "Layout/Pemesanan.php" ?>

    <footer class="bg-dark text-white text-center py-3 border-top">
        <div class="container">
            <p class="mb-0 small">&copy; 2026 Niquel - Jangan plek ketiplek pls</p>
        </div>
    </footer>
    <!-- Aos -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- Bootstrap -->
    <script src="asset/js/bootstrap.bundle.min.js"></script>
</body>

</html>