<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_distribusi = $_POST['id_distribusi'];
    $id_pupuk_baru = $_POST['id_pupuk'];
    $id_pengecer = $_POST['id_pengecer'];
    $satuan = $_POST['satuan'];
    $tujuan = $_POST['tujuan'];
    $jumlah_keluar_baru = $_POST['jumlah_keluar'];
    $harga_distribusi = $_POST['harga_distribusi'];
    $harga_total_baru = $_POST['harga_total'];
    $tanggal_distribusi = date("j F Y", strtotime($_POST['tanggal_distribusi']));
    $dokumentasi = '';

    // **Cek Data Lama**
    $query_old = "SELECT id_pupuk, jumlah_keluar, harga_distribusi, dokumentasi FROM distribusi WHERE id_distribusi = ?";
    $stmt_old = $koneksi->prepare($query_old);
    if (!$stmt_old) {
        die("Error: " . $koneksi->error);
    }
    $stmt_old->bind_param("i", $id_distribusi);
    $stmt_old->execute();
    $stmt_old->bind_result($id_pupuk_lama, $jumlah_keluar_lama, $harga_distribusi_lama, $dokumentasi_lama);
    $stmt_old->fetch();
    $stmt_old->close();

    // **Proses Upload File Dokumentasi Jika Ada**
    if (!empty($_FILES['dokumentasi']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["dokumentasi"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // **Cek Format File**
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "pdf") {
            echo "<script>alert('Format file harus JPG, JPEG, PNG, atau PDF!'); window.location.href='../distribusi.php';</script>";
            exit();
        }

        // **Hapus File Lama Jika Ada**
        if (!empty($dokumentasi_lama)) {
            $file_path_lama = "../uploads/" . $dokumentasi_lama;
            if (file_exists($file_path_lama)) {
                unlink($file_path_lama);
            }
        }

        // **Pindahkan File Baru**
        if (move_uploaded_file($_FILES["dokumentasi"]["tmp_name"], $target_file)) {
            $dokumentasi = $file_name;
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file!'); window.location.href='../distribusi.php';</script>";
            exit();
        }
    } else {
        // **Gunakan Dokumentasi Lama Jika Tidak Ada File Baru**
        $dokumentasi = $dokumentasi_lama;
    }

    // **Ambil Harga Pupuk dari `pupuk`**
    $query_harga_pupuk = "SELECT harga FROM pupuk WHERE id_pupuk = ?";
    $stmt_harga_pupuk = $koneksi->prepare($query_harga_pupuk);
    if (!$stmt_harga_pupuk) {
        die("Error: " . $koneksi->error);
    }
    $stmt_harga_pupuk->bind_param("i", $id_pupuk_baru);
    $stmt_harga_pupuk->execute();
    $stmt_harga_pupuk->bind_result($harga_pupuk);
    $stmt_harga_pupuk->fetch();
    $stmt_harga_pupuk->close();

    if ($harga_pupuk === null) {
        die("Error: Harga pupuk tidak ditemukan!");
    }

    // **Kembalikan stok lama jika `id_pupuk` atau `jumlah_keluar` berubah**
    if ($id_pupuk_lama !== $id_pupuk_baru || $jumlah_keluar_lama !== $jumlah_keluar_baru) {
        $query_restore_stok = "UPDATE stok SET stok = stok + ?, harga_total = harga_total + (? * ?) WHERE id_pupuk = ?";
        $stmt_restore_stok = $koneksi->prepare($query_restore_stok);
        if (!$stmt_restore_stok) {
            die("Error: " . $koneksi->error);
        }
        $stmt_restore_stok->bind_param("idii", $jumlah_keluar_lama, $jumlah_keluar_lama, $harga_pupuk, $id_pupuk_lama);
        $stmt_restore_stok->execute();
        $stmt_restore_stok->close();
    }

    // **Update Data Distribusi**
    $query_update = "UPDATE distribusi SET id_pupuk = ?, id_pengecer = ?, satuan = ?, tujuan = ?, tanggal_distribusi = ?, jumlah_keluar = ?, harga_distribusi = ?, harga_total = ?, dokumentasi = ? WHERE id_distribusi = ?";
    $stmt_update = $koneksi->prepare($query_update);
    if (!$stmt_update) {
        die("Error: " . $koneksi->error);
    }
    $stmt_update->bind_param("iisssiddsi", $id_pupuk_baru, $id_pengecer, $satuan, $tujuan, $tanggal_distribusi, $jumlah_keluar_baru, $harga_distribusi, $harga_total_baru, $dokumentasi, $id_distribusi);
    $stmt_update->execute();
    $stmt_update->close();

    // **Kurangi stok baru**
    $query_check_stok = "SELECT stok, harga_total FROM stok WHERE id_pupuk = ?";
    $stmt_check_stok = $koneksi->prepare($query_check_stok);
    if (!$stmt_check_stok) {
        die("Error: " . $koneksi->error);
    }
    $stmt_check_stok->bind_param("i", $id_pupuk_baru);
    $stmt_check_stok->execute();
    $stmt_check_stok->bind_result($stok_sekarang, $harga_total_sekarang);
    $stmt_check_stok->fetch();
    $stmt_check_stok->close();

    if ($stok_sekarang === null) {
        die("Error: Pupuk dengan ID $id_pupuk_baru tidak ditemukan di stok!");
    }

    $stok_baru = $stok_sekarang - $jumlah_keluar_baru;
    $harga_total_baru_stok = $harga_total_sekarang - ($jumlah_keluar_baru * $harga_pupuk);

    $query_update_stok_final = "UPDATE stok SET stok = ?, harga_total = ? WHERE id_pupuk = ?";
    $stmt_update_stok_final = $koneksi->prepare($query_update_stok_final);
    if (!$stmt_update_stok_final) {
        die("Error: " . $koneksi->error);
    }
    $stmt_update_stok_final->bind_param("idi", $stok_baru, $harga_total_baru_stok, $id_pupuk_baru);
    $stmt_update_stok_final->execute();
    $stmt_update_stok_final->close();

    echo "<script>alert('Distribusi berhasil diperbarui dan stok diperbarui!'); window.location.href='../distribusi.php';</script>";

    $koneksi->close();
} else {
    header("Location: ../distribusi.php");
    exit();
}
?>
