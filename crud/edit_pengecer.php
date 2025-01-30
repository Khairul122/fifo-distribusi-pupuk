<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengecer = $_POST['id_pengecer'];
    $nama_pengecer = $_POST['nama_pengecer'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    if (empty($nama_pengecer) || empty($jenis_kelamin) || empty($tanggal_lahir) || empty($no_hp) || empty($alamat)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../pengecer.php';</script>";
        exit();
    }

    $query_update = "UPDATE pengecer SET nama_pengecer = ?, jenis_kelamin = ?, tanggal_lahir = ?, no_hp = ?, alamat = ? WHERE id_pengecer = ?";
    $stmt_update = $koneksi->prepare($query_update);
    $stmt_update->bind_param("sssssi", $nama_pengecer, $jenis_kelamin, $tanggal_lahir, $no_hp, $alamat, $id_pengecer);

    if ($stmt_update->execute()) {
        echo "<script>alert('Pengecer berhasil diperbarui!'); window.location.href='../pengecer.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui pengecer!'); window.location.href='../pengecer.php';</script>";
    }

    $stmt_update->close();
    $koneksi->close();
} else {
    header("Location: ../pengecer.php");
    exit();
}
?>
