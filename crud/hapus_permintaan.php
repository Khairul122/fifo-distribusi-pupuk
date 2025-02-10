<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_permintaan = $_GET['id'];

    $query_select = "SELECT dokumentasi FROM permintaan WHERE id_permintaan = ?";
    $stmt_select = $koneksi->prepare($query_select);
    $stmt_select->bind_param("i", $id_permintaan);
    $stmt_select->execute();
    $stmt_select->bind_result($dokumentasi);
    $stmt_select->fetch();
    $stmt_select->close();

    if (!empty($dokumentasi) && file_exists("../uploads/" . $dokumentasi)) {
        unlink("../uploads/" . $dokumentasi);
    }

    $query_delete = "DELETE FROM permintaan WHERE id_permintaan = ?";
    $stmt_delete = $koneksi->prepare($query_delete);
    $stmt_delete->bind_param("i", $id_permintaan);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Data permintaan berhasil dihapus!'); window.location.href='../permintaan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data!'); window.location.href='../permintaan.php';</script>";
    }

    $stmt_delete->close();
    $koneksi->close();
} else {
    header("Location: ../permintaan.php");
    exit();
}
?>
