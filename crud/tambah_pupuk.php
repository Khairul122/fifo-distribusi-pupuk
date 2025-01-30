<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pupuk = $_POST['nama_pupuk'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO pupuk (nama_pupuk, satuan, harga) VALUES ('$nama_pupuk', '$satuan', '$harga')";

    if ($koneksi->query($query) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='../pupuk.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }

    $koneksi->close();
}
?>
