<?php
session_start();//memulai session
session_destroy();// memberhentikan session
header("location:index.php");// kembali ke index.php
?>