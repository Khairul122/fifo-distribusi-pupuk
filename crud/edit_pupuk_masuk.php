<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pupuk_masuk = $_POST['id_pupuk_masuk'];
    $id_pupuk = $_POST['id_pupuk'];
    $jumlah_masuk_baru = $_POST['jumlah_masuk'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
    $dokumentasi = '';

    if (empty($id_pupuk) || empty($jumlah_masuk_baru) || empty($tanggal_masuk) || empty($tanggal_kadaluarsa)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../pupuk_masuk.php';</script>";
        exit();
    }

    $query_old = "SELECT jumlah_masuk, dokumentasi FROM pupuk_masuk WHERE id_pupuk_masuk = ?";
    $stmt_old = $koneksi->prepare($query_old);
    $stmt_old->bind_param("i", $id_pupuk_masuk);
    $stmt_old->execute();
    $stmt_old->bind_result($jumlah_masuk_lama, $dokumentasi_lama);
    $stmt_old->fetch();
    $stmt_old->close();

    if (!empty($_FILES['dokumentasi']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["dokumentasi"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "pdf") {
            echo "<script>alert('Format file harus JPG, JPEG, PNG, atau PDF!'); window.location.href='../pupuk_masuk.php';</script>";
            exit();
        }

        if (move_uploaded_file($_FILES["dokumentasi"]["tmp_name"], $target_file)) {
            $dokumentasi = $file_name;
            if (!empty($dokumentasi_lama) && file_exists("../uploads/" . $dokumentasi_lama)) {
                unlink("../uploads/" . $dokumentasi_lama);
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file!'); window.location.href='../pupuk_masuk.php';</script>";
            exit();
        }
    } else {
        $dokumentasi = $dokumentasi_lama;
    }

    $query_update = "UPDATE pupuk_masuk SET id_pupuk = ?, jumlah_masuk = ?, tanggal_masuk = ?, tanggal_kadaluarsa = ?, dokumentasi = ? WHERE id_pupuk_masuk = ?";
    $stmt_update = $koneksi->prepare($query_update);
    $stmt_update->bind_param("iisssi", $id_pupuk, $jumlah_masuk_baru, $tanggal_masuk, $tanggal_kadaluarsa, $dokumentasi, $id_pupuk_masuk);
    
    
    if ($stmt_update->execute()) {
        $selisih_stok = $jumlah_masuk_baru - $jumlah_masuk_lama;

        $query_update_stok = "UPDATE stok SET stok = stok + ? WHERE id_pupuk = ?";
        $stmt_update_stok = $koneksi->prepare($query_update_stok);
        $stmt_update_stok->bind_param("ii", $selisih_stok, $id_pupuk);
        $stmt_update_stok->execute();
        $stmt_update_stok->close();

        echo "<script>alert('Data pupuk masuk berhasil diperbarui!'); window.location.href='../pupuk_masuk.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui data!'); window.location.href='../pupuk_masuk.php';</script>";
    }

    $stmt_update->close();
    $koneksi->close();
} else {
    header("Location: ../pupuk_masuk.php");
    exit();
}
?>
