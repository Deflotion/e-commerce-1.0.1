<?php
include '../db/koneksi.php';
if (isset($_POST['submit'])) {
    $status   = $_POST['status']   = "user";
    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $result = mysqli_query($conn, "INSERT INTO user SET username = '$Username' , password = '$Password', status = '$status'");
    $row    = mysqli_fetch_assoc($result);
    header('location:login.php');
    // echo "<script>alert('Data sudah masuk')</script>";
}
