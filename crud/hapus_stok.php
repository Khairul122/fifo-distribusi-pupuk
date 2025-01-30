<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_stok = $_GET['id'];

    $query_delete = "DELETE FROM stok WHERE id_stok = ?";
    $stmt_delete = $koneksi->prepare($query_delete);
    $stmt_delete->bind_param("i", $id_stok);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Data stok berhasil dihapus!'); window.location.href='../stok.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data stok!'); window.location.href='../stok.php';</script>";
    }

    $stmt_delete->close();
    $koneksi->close();
} else {
    header("Location: ../stok.php");
    exit();
}
?>
