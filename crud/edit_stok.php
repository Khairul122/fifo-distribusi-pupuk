<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_stok = $_POST['id_stok'];
    $stok = $_POST['stok'];
    $harga_total = $_POST['harga_total']; 

    if (!is_numeric($harga_total) || $harga_total <= 0) {
        echo "<script>alert('Terjadi kesalahan pada perhitungan harga!'); window.location.href='../stok.php';</script>";
        exit();
    }
    
    $query_update = "UPDATE stok SET stok = ?, harga_total = ? WHERE id_stok = ?";
    $stmt_update = $koneksi->prepare($query_update);
    $stmt_update->bind_param("idi", $stok, $harga_total, $id_stok);

    if ($stmt_update->execute()) {
        echo "<script>alert('Stok berhasil diperbarui!'); window.location.href='../stok.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui stok!'); window.location.href='../stok.php';</script>";
    }

    $stmt_update->close();
    $koneksi->close();
} else {
    header("Location: ../stok.php");
    exit();
}
?>
