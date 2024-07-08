<?php
require 'koneksi.php';

if (!isset($_GET['id_guru'])) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .container-custom {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
            }
            .icon {
                font-size: 50px;
                color: yellow;
            }
        </style>
    </head>
    <body>
        <div class="container container-custom">
            <div class="icon">⚠️</div>
            <h3>Error: id_guru tidak disertakan.</h3>
        </div>
    </body>
    </html>';
    exit;
}

$id_guru = $_GET['id_guru'];

$sql = "SELECT nama_guru FROM guru WHERE id_guru = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$stmt->bind_result($nama_guru);
$stmt->fetch();

if (!$nama_guru) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .container-custom {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
            }
            .icon {
                font-size: 50px;
                color: yellow;
            }
        </style>
    </head>
    <body>
        <div class="container container-custom">
            <div class="icon">⚠️</div>
            <h3>Error: Guru tidak ditemukan.</h3>
        </div>
    </body>
    </html>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge MPLS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="Aset/skaga.png">  
    <style>
        .container-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card-custom {
            width: auto;
        }
        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container container-custom">
        <div class="card card-custom">
            <img src="tampil_gambar.php?id_guru=<?= $id_guru ?>" class="card-img-top" alt="Foto Guru">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($nama_guru) ?></h5>
                <form action="proses.php" method="post">
                    <input type="hidden" name="id_guru" value="<?= htmlspecialchars($id_guru) ?>">
                    <div class="form-group">
                        <label for="nisn">NISN:</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukkan NISN-mu" required>
                    </div>
                    <button type="submit" class="btn btn-primary">OK</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
