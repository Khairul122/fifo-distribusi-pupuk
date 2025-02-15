<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_pupuk_masuk = $_GET['id'];

    // Ambil data pupuk masuk sebelum dihapus
    $query_get = "SELECT id_pupuk, jumlah_masuk, dokumentasi FROM pupuk_masuk WHERE id_pupuk_masuk = ?";
    $stmt_get = $koneksi->prepare($query_get);
    $stmt_get->bind_param("i", $id_pupuk_masuk);
    $stmt_get->execute();
    $stmt_get->bind_result($id_pupuk, $jumlah_masuk, $dokumentasi);
    $stmt_get->fetch();
    $stmt_get->close();

    if ($id_pupuk) {
        // Hapus data dari tabel pupuk_masuk
        $query_delete = "DELETE FROM pupuk_masuk WHERE id_pupuk_masuk = ?";
        $stmt_delete = $koneksi->prepare($query_delete);
        $stmt_delete->bind_param("i", $id_pupuk_masuk);

        if ($stmt_delete->execute()) {
            $stmt_delete->close();
            
            // Hapus dokumentasi jika ada
            if (!empty($dokumentasi) && file_exists("../uploads/" . $dokumentasi)) {
                unlink("../uploads/" . $dokumentasi);
            }
            
            // Kurangi stok pupuk yang sesuai
            $query_update_stok = "UPDATE stok SET stok = stok - ? WHERE id_pupuk = ?";
            $stmt_update_stok = $koneksi->prepare($query_update_stok);
            $stmt_update_stok->bind_param("ii", $jumlah_masuk, $id_pupuk);
            $stmt_update_stok->execute();
            $stmt_update_stok->close();
            
            echo "<script>alert('Data pupuk masuk berhasil dihapus!'); window.location.href='../pupuk_masuk.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus data!'); window.location.href='../pupuk_masuk.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='../pupuk_masuk.php';</script>";
    }
} else {
    header("Location: ../pupuk_masuk.php");
    exit();
}
?>
