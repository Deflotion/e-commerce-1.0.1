<?php
    $conn = mysqli_connect("localhost","root","","ecommerce");
    if($err = mysqli_connect_error()){
        die($err);
    }
?>