<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pupuk = $_POST['id_pupuk'];
    $nama_pupuk = $_POST['nama_pupuk'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];

    $query = "UPDATE pupuk SET nama_pupuk='$nama_pupuk', satuan='$satuan', harga='$harga' WHERE id_pupuk='$id_pupuk'";

    if ($koneksi->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='../pupuk.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $koneksi->close();
}
?>
