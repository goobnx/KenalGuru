<?php
require 'koneksi.php';

$sisa_guru = null;
$nama_siswa = null;
$nama_kelas = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn = $_POST['nisn'];

    // Cek apakah NISN ada di database siswa dan ambil nama siswa serta nama kelas
    $sql = "SELECT siswa.id_siswa, siswa.nama_siswa, kelas.nama_kelas 
            FROM siswa 
            JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
            WHERE siswa.nisn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $stmt->bind_result($id_siswa, $nama_siswa, $nama_kelas);
    $stmt->fetch();
    $stmt->close();

    if ($id_siswa) {
        // Hitung total guru
        $sql = "SELECT COUNT(*) FROM guru";
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        $total_guru = $row[0];

        // Hitung jumlah guru yang sudah dikunjungi
        $sql = "SELECT COUNT(*) FROM transaksi WHERE id_siswa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_siswa);
        $stmt->execute();
        $stmt->bind_result($guru_dikunjungi);
        $stmt->fetch();
        $stmt->close();

        // Hitung sisa guru yang belum dikunjungi
        $sisa_guru = $total_guru - $guru_dikunjungi;
    } else {
        $sisa_guru = "NISN tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Sisa Guru</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .form-inline-custom {
            display: flex;
            align-items: center;
        }
        .form-inline-custom .form-control {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container container-custom">
        <h3>Cek Sisa Guru</h3>
        <form class="form-inline form-inline-custom" action="sisa_guru.php" method="post">
            <input type="text" class="form-control" name="nisn" placeholder="NISN" value="<?= isset($nisn) ? htmlspecialchars($nisn) : '' ?>" required>
            <button type="submit" class="btn btn-primary">Cek</button>
        </form>
        <?php if ($sisa_guru !== null): ?>
            <?php if (is_numeric($sisa_guru)): ?>
                <p class="mt-3">Nama Siswa: <?= htmlspecialchars($nama_siswa) ?></p>
                <p>Kelas: <?= htmlspecialchars($nama_kelas) ?></p>
                <p>Sisa guru yang belum dikunjungi: <?= $sisa_guru ?></p>
            <?php else: ?>
                <p class="mt-3 text-danger"><?= $sisa_guru ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
