<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pengecer = $_GET['id'];

    $query_delete = "DELETE FROM pengecer WHERE id_pengecer = ?";
    $stmt_delete = $koneksi->prepare($query_delete);
    $stmt_delete->bind_param("i", $id_pengecer);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Pengecer berhasil dihapus!'); window.location.href='../pengecer.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus pengecer!'); window.location.href='../pengecer.php';</script>";
    }

    $stmt_delete->close();
    $koneksi->close();
} else {
    header("Location: ../pengecer.php");
    exit();
}
?>
