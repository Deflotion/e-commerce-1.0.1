<?php
session_start();
include '../db/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
$cek = mysqli_num_rows($sql);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($sql);
    if ($data['status'] == "admin") {
        $_SESSION['username'] = $usename;
        $_SESSION['status']   = "admin";
        header("Location: ../admin/index.php");
    } else if ($data['status'] == "user") {
        $_SESSION['username'] = $usename;
        $_SESSION['status']   = "user";
        header("Location: ../index.php");
    }
} else {
    header("Location: ./login.php?pesan=gagal");
}
