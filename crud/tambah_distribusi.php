<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pupuk = $_POST['id_pupuk'];
    $id_pengecer = $_POST['id_pengecer'];
    $satuan = $_POST['satuan'];
    $tujuan = $_POST['tujuan'];
    $kecamatan = $_POST['kecamatan']; 
    $jumlah_keluar = $_POST['jumlah_keluar'];
    $harga_distribusi = $_POST['harga_distribusi'];
    $harga_total = $_POST['harga_total'];
    $tanggal_distribusi = date("j F Y");
    $dokumentasi = '';

    if (empty($id_pupuk) || empty($id_pengecer) || empty($satuan) || empty($tujuan) || empty($kecamatan) || empty($jumlah_keluar) || empty($harga_distribusi)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../distribusi.php';</script>";
        exit();
    }

    if (!empty($_FILES['dokumentasi']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["dokumentasi"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "pdf") {
            echo "<script>alert('Format file harus JPG, JPEG, PNG, atau PDF!'); window.location.href='../distribusi.php';</script>";
            exit();
        }

        if (move_uploaded_file($_FILES["dokumentasi"]["tmp_name"], $target_file)) {
            $dokumentasi = $file_name;
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file!'); window.location.href='../distribusi.php';</script>";
            exit();
        }
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

    $query_insert = "INSERT INTO distribusi (id_pupuk, id_pengecer, satuan, tujuan, kecamatan, tanggal_distribusi, jumlah_keluar, harga_distribusi, harga_total, dokumentasi) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("iissssidds", $id_pupuk, $id_pengecer, $satuan, $tujuan, $kecamatan, $tanggal_distribusi, $jumlah_keluar, $harga_distribusi, $harga_total, $dokumentasi);

    if ($stmt_insert->execute()) {
        $query_check_stok = "SELECT stok, harga_total FROM stok WHERE id_pupuk = ?";
        $stmt_check_stok = $koneksi->prepare($query_check_stok);
        $stmt_check_stok->bind_param("i", $id_pupuk);
        $stmt_check_stok->execute();
        $stmt_check_stok->bind_result($stok_sekarang, $harga_total_sekarang);
        $stmt_check_stok->fetch();
        $stmt_check_stok->close();

        if ($stok_sekarang !== null && $stok_sekarang >= $jumlah_keluar) {
            $stok_baru = $stok_sekarang - $jumlah_keluar;
            $harga_total_baru = $harga_total_sekarang - ($jumlah_keluar * $harga_pupuk);

            $query_update_stok = "UPDATE stok SET stok = ?, harga_total = ? WHERE id_pupuk = ?";
            $stmt_update_stok = $koneksi->prepare($query_update_stok);
            $stmt_update_stok->bind_param("idi", $stok_baru, $harga_total_baru, $id_pupuk);
            $stmt_update_stok->execute();
            $stmt_update_stok->close();
        } else {
            echo "<script>alert('Stok tidak mencukupi untuk distribusi ini!'); window.location.href='../distribusi.php';</script>";
            exit();
        }

        echo "<script>alert('Distribusi berhasil ditambahkan dan stok diperbarui!'); window.location.href='../distribusi.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan distribusi!'); window.location.href='../distribusi.php';</script>";
    }

    $stmt_insert->close();
    $koneksi->close();
} else {
    header("Location: ../distribusi.php");
    exit();
}
?>
