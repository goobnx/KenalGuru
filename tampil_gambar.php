<?php
require 'koneksi.php';

$id_guru = $_GET['id_guru'];

$sql = "SELECT foto FROM guru WHERE id_guru = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$stmt->bind_result($foto);
$stmt->fetch();

header("Content-type: image/jpeg");
echo $foto;

$stmt->close();
$conn->close();
?>
