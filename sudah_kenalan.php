<?php
session_start();

// Periksa apakah halaman ini telah diakses sebelumnya dalam sesi ini
if (isset($_SESSION['sudah_kenalan'])) {
    // Arahkan ke halaman 'cari_guru_lain.php'
    header("Location: cari_guru_lain.php");
    exit();
}

// Tandai bahwa halaman ini telah diakses
$_SESSION['sudah_kenalan'] = true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudah Kenalan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <div class="alert alert-success">
            <h4 class="alert-heading">Sudah Kenalan</h4>
            <p>Terima kasih. Kamu sudah berkenalan dengan guru ini.</p>
        </div>
    </div>
</body>
</html>

