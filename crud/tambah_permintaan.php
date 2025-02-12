<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal_permintaan = $_POST['tanggal_permintaan'];
    $nama_distributor = $_POST['nama_distributor'];
    $id_pengecer = $_POST['id_pengecer']; 
    $id_pupuk = $_POST['id_pupuk'];
    $jumlah = $_POST['jumlah'];
    $kecamatan = $_POST['kecamatan'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];
    $dokumentasi = '';

    if (empty($tanggal_permintaan) || empty($nama_distributor) || empty($id_pengecer) || empty($id_pupuk) || empty($jumlah) || empty($kecamatan) || empty($status)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../permintaan.php';</script>";
        exit();
    }

    if (!empty($_FILES['dokumentasi']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["dokumentasi"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "pdf") {
            echo "<script>alert('Format file harus JPG, JPEG, PNG, atau PDF!'); window.location.href='../permintaan.php';</script>";
            exit();
        }

        if (move_uploaded_file($_FILES["dokumentasi"]["tmp_name"], $target_file)) {
            $dokumentasi = $file_name;
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file!'); window.location.href='../permintaan.php';</script>";
            exit();
        }
    }

    $query_insert = "INSERT INTO permintaan (tanggal_permintaan, nama_distributor, id_pengecer, id_pupuk, jumlah, kecamatan, dokumentasi, keterangan, status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("ssiiissss", $tanggal_permintaan, $nama_distributor, $id_pengecer, $id_pupuk, $jumlah, $kecamatan, $dokumentasi, $keterangan, $status);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Permintaan berhasil ditambahkan!'); window.location.href='../permintaan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan permintaan!'); window.location.href='../permintaan.php';</script>";
    }

    $stmt_insert->close();
    $koneksi->close();
} else {
    header("Location: ../permintaan.php");
    exit();
}
