<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pupuk = $_GET['id'];

    $query = "DELETE FROM pupuk WHERE id_pupuk='$id_pupuk'";

    if ($koneksi->query($query) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='../pupuk.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $koneksi->close();
}
?>
