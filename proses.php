<?php
// Menggunakan file koneksi
require 'koneksi.php';

$id_guru = $_POST['id_guru'];
$nisn = $_POST['nisn'];

// Cek apakah NISN ada di database siswa
$sql = "SELECT id_siswa FROM siswa WHERE nisn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nisn);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

if ($siswa) {
    $id_siswa = $siswa['id_siswa'];
    
    // Cek apakah siswa sudah berkenalan dengan guru ini
    $sql = "SELECT * FROM transaksi WHERE id_guru = ? AND id_siswa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_guru, $id_siswa);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaksi = $result->fetch_assoc();

    if ($transaksi) {
        header("Location: cari_guru_lain.php");
    } else {
        // Insert data transaksi baru
        $sql = "INSERT INTO transaksi (id_guru, id_siswa) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_guru, $id_siswa);
        $stmt->execute();

        header("Location: sudah_kenalan.php");
    }
} else {
    echo '<script>alert("NISN tidak ditemukan"); window.location.href = "index.php?id_guru=' . $id_guru . '";</script>';
}

$stmt->close();
$conn->close();
?>
