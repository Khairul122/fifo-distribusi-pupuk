<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pupuk = $_POST['id_pupuk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga']; 
    $harga_total = $_POST['harga_total']; 

    if (!is_numeric($harga_total) || $harga_total <= 0) {
        echo "<script>alert('Terjadi kesalahan pada perhitungan harga!'); window.location.href='../stok.php';</script>";
        exit();
    }

    $query_check = "SELECT id_stok FROM stok WHERE id_pupuk = ?";
    $stmt_check = $koneksi->prepare($query_check);
    $stmt_check->bind_param("i", $id_pupuk);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $query_update = "UPDATE stok SET stok = stok + ?, harga_total = harga_total + ? WHERE id_pupuk = ?";
        $stmt_update = $koneksi->prepare($query_update);
        $stmt_update->bind_param("idi", $stok, $harga_total, $id_pupuk);

        if ($stmt_update->execute()) {
            echo "<script>alert('Stok berhasil diperbarui!'); window.location.href='../stok.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat memperbarui stok!'); window.location.href='../stok.php';</script>";
        }
    } else {
        $query_insert = "INSERT INTO stok (id_pupuk, stok, harga_total) VALUES (?, ?, ?)";
        $stmt_insert = $koneksi->prepare($query_insert);
        $stmt_insert->bind_param("iid", $id_pupuk, $stok, $harga_total);

        if ($stmt_insert->execute()) {
            echo "<script>alert('Stok baru berhasil ditambahkan!'); window.location.href='../stok.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan stok!'); window.location.href='../stok.php';</script>";
        }
    }

    $stmt_check->close();
    $stmt_update->close();
    $stmt_insert->close();
    $koneksi->close();
} else {
    header("Location: ../stok.php");
    exit();
}
?>
