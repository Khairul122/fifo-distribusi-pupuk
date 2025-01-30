<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pupuk = $_POST['id_pupuk'];
    $jumlah_masuk = $_POST['jumlah_masuk'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
    $dokumentasi = '';

    if (empty($id_pupuk) || empty($jumlah_masuk) || empty($tanggal_masuk) || empty($tanggal_kadaluarsa)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../pupuk_masuk.php';</script>";
        exit();
    }

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
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file!'); window.location.href='../pupuk_masuk.php';</script>";
            exit();
        }
    }

    $query_insert = "INSERT INTO pupuk_masuk (id_pupuk, jumlah_masuk, tanggal_masuk, tanggal_kadaluarsa, dokumentasi) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("iisss", $id_pupuk, $jumlah_masuk, $tanggal_masuk, $tanggal_kadaluarsa, $dokumentasi);

    if ($stmt_insert->execute()) {
        $query_harga = "SELECT harga FROM pupuk WHERE id_pupuk = ?";
        $stmt_harga = $koneksi->prepare($query_harga);
        $stmt_harga->bind_param("i", $id_pupuk);
        $stmt_harga->execute();
        $stmt_harga->bind_result($harga_pupuk);
        $stmt_harga->fetch();
        $stmt_harga->close();

        if (!$harga_pupuk) {
            echo "<script>alert('Terjadi kesalahan, harga pupuk tidak ditemukan!'); window.location.href='../pupuk_masuk.php';</script>";
            exit();
        }

        $harga_total_masuk = $harga_pupuk * $jumlah_masuk;

        $query_check_stok = "SELECT stok, harga_total FROM stok WHERE id_pupuk = ?";
        $stmt_check_stok = $koneksi->prepare($query_check_stok);
        $stmt_check_stok->bind_param("i", $id_pupuk);
        $stmt_check_stok->execute();
        $stmt_check_stok->bind_result($stok_sekarang, $harga_total_sekarang);
        $stmt_check_stok->fetch();
        $stmt_check_stok->close();

        if ($stok_sekarang !== null) {
            $query_update_stok = "UPDATE stok SET stok = stok + ?, harga_total = harga_total + ? WHERE id_pupuk = ?";
            $stmt_update_stok = $koneksi->prepare($query_update_stok);
            $stmt_update_stok->bind_param("idi", $jumlah_masuk, $harga_total_masuk, $id_pupuk);
            $stmt_update_stok->execute();
            $stmt_update_stok->close();
        } else {
            $query_insert_stok = "INSERT INTO stok (id_pupuk, stok, harga_total) VALUES (?, ?, ?)";
            $stmt_insert_stok = $koneksi->prepare($query_insert_stok);
            $stmt_insert_stok->bind_param("iid", $id_pupuk, $jumlah_masuk, $harga_total_masuk);
            $stmt_insert_stok->execute();
            $stmt_insert_stok->close();
        }

        echo "<script>alert('Pupuk masuk berhasil ditambahkan dan stok diperbarui!'); window.location.href='../pupuk_masuk.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan pupuk masuk!'); window.location.href='../pupuk_masuk.php';</script>";
    }

    $stmt_insert->close();
    $koneksi->close();
} else {
    header("Location: ../pupuk_masuk.php");
    exit();
}
?>
