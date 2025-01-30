<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengecer = $_POST['nama_pengecer'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    if (empty($nama_pengecer) || empty($jenis_kelamin) || empty($tanggal_lahir) || empty($no_hp) || empty($alamat)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../pengecer.php';</script>";
        exit();
    }

    $query_insert = "INSERT INTO pengecer (nama_pengecer, jenis_kelamin, tanggal_lahir, no_hp, alamat) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("sssss", $nama_pengecer, $jenis_kelamin, $tanggal_lahir, $no_hp, $alamat);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Pengecer berhasil ditambahkan!'); window.location.href='../pengecer.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan pengecer!'); window.location.href='../pengecer.php';</script>";
    }

    $stmt_insert->close();
    $koneksi->close();
} else {
    header("Location: ../pengecer.php");
    exit();
}
?>
