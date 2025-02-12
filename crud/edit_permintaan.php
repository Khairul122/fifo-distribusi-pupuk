<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_permintaan = $_POST['id_permintaan'];
    $tanggal_permintaan = $_POST['tanggal_permintaan'];
    $nama_distributor = $_POST['nama_distributor'];
    $id_pengecer = $_POST['id_pengecer'];
    $id_pupuk = $_POST['id_pupuk'];
    $jumlah = $_POST['jumlah'];
    $kecamatan = $_POST['kecamatan'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];
    
    $dokumentasi = isset($_POST['dokumentasi_lama']) ? $_POST['dokumentasi_lama'] : '';

    if (!empty($_FILES['dokumentasi']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["dokumentasi"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($file_type, ['jpg', 'png', 'jpeg', 'pdf'])) {
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

    $query_update = "UPDATE permintaan 
                     SET tanggal_permintaan = ?, nama_distributor = ?, id_pengecer = ?, id_pupuk = ?, jumlah = ?, kecamatan = ?, dokumentasi = ?, keterangan = ?, status = ? 
                     WHERE id_permintaan = ?";
    $stmt_update = $koneksi->prepare($query_update);
    $stmt_update->bind_param("ssiiissssi", $tanggal_permintaan, $nama_distributor, $id_pengecer, $id_pupuk, $jumlah, $kecamatan, $dokumentasi, $keterangan, $status, $id_permintaan);

    if ($stmt_update->execute()) {
        echo "<script>alert('Permintaan berhasil diperbarui!'); window.location.href='../permintaan.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui permintaan!'); window.location.href='../permintaan.php';</script>";
    }

    $stmt_update->close();
    $koneksi->close();
} else {
    header("Location: ../permintaan.php");
    exit();
}
?>
