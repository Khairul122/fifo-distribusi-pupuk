<?php
session_start();
include 'koneksi.php'; 

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE username = ? AND password = SHA(?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['level'] = $row['level'];
    
    echo "<script>alert('Login Berhasil!'); window.location.href='home.php';</script>";
} else {
    echo "<script>alert('Login Gagal! Username atau Password salah.'); window.location.href='index.php';</script>";
}

$stmt->close();
$koneksi->close();
?>
