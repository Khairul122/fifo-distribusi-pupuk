<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_distribusi = $_GET['id'];

    $query_get_distribusi = "SELECT id_pupuk, jumlah_keluar, harga_distribusi, dokumentasi FROM distribusi WHERE id_distribusi = ?";
    $stmt_get = $koneksi->prepare($query_get_distribusi);
    if (!$stmt_get) {
        die("Error: " . $koneksi->error);
    }
    $stmt_get->bind_param("i", $id_distribusi);
    $stmt_get->execute();
    $stmt_get->bind_result($id_pupuk, $jumlah_keluar, $harga_distribusi, $dokumentasi);
    $stmt_get->fetch();
    $stmt_get->close();

    if (!$id_pupuk) {
        echo "<script>alert('Distribusi tidak ditemukan!'); window.location.href='../distribusi.php';</script>";
        exit();
    }

    $query_harga_pupuk = "SELECT harga FROM pupuk WHERE id_pupuk = ?";
    $stmt_harga_pupuk = $koneksi->prepare($query_harga_pupuk);
    if (!$stmt_harga_pupuk) {
        die("Error: " . $koneksi->error);
    }
    $stmt_harga_pupuk->bind_param("i", $id_pupuk);
    $stmt_harga_pupuk->execute();
    $stmt_harga_pupuk->bind_result($harga_pupuk);
    $stmt_harga_pupuk->fetch();
    $stmt_harga_pupuk->close();

    if (!$harga_pupuk) {
        die("Error: Harga pupuk tidak ditemukan!");
    }

    $harga_total_kembali = $jumlah_keluar * $harga_pupuk;
    $query_restore_stok = "UPDATE stok SET stok = stok + ?, harga_total = harga_total + ? WHERE id_pupuk = ?";
    $stmt_restore_stok = $koneksi->prepare($query_restore_stok);
    if (!$stmt_restore_stok) {
        die("Error: " . $koneksi->error);
    }
    $stmt_restore_stok->bind_param("idi", $jumlah_keluar, $harga_total_kembali, $id_pupuk);
    $stmt_restore_stok->execute();
    $stmt_restore_stok->close();

    if (!empty($dokumentasi)) {
        $file_path = "../uploads/" . $dokumentasi;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $query_delete = "DELETE FROM distribusi WHERE id_distribusi = ?";
    $stmt_delete = $koneksi->prepare($query_delete);
    if (!$stmt_delete) {
        die("Error: " . $koneksi->error);
    }
    $stmt_delete->bind_param("i", $id_distribusi);
    if ($stmt_delete->execute()) {
        echo "<script>alert('Distribusi berhasil dihapus dan stok dikembalikan!'); window.location.href='../distribusi.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus distribusi!'); window.location.href='../distribusi.php';</script>";
    }
    $stmt_delete->close();
} else {
    header("Location: ../distribusi.php");
    exit();
}

$koneksi->close();
?>
