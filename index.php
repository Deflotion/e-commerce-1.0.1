<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Geming</title>
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="index.php" class="nav-link active"><h4>Shop Geming</h4></a>
        </div>
        <ul class="navbar-item">
            <li class="nav-item">
                <a href="index.php" class="nav-link active">Home</a></li>
            <li class="nav-item">
                <a href="order/" class="nav-link active">Order</a>
            </li>
            <?php
                session_start();

                if (isset($_SESSION['username'])) {
                    if ($_SESSION['username'] == "proteq") {
                        echo '
                        <li class="nav-item">
                            <a href="admin/index.php">Index</a>
                        </li>';
                    } else {
                        echo '
                            <li class="nav-item">
                                <a href="logout.php" class="nav-link">Logout</a>
                            </li>';
                    }
                } else {
                    echo '
                            <li class="nav-item">
                                <a href="./login/login.php" class="nav-link">Login</a>
                            </li>';
                }
            ?>
        </ul>
        <a href="cart/" class="nav-link active">Keranjang</a>
    </nav>
    <div class="container">
        <div class="section-title">
            Product
        </div>
        <div class="row-card">
            <?php
                include 'db/koneksi.php';
                $query = 'SELECT * FROM printer_tb ORDER BY IdPrinter DESC';
                $rs    = mysqli_query($conn, $query);
            while ($data = mysqli_fetch_array($rs)) {?>
            <div class="col-md-3">
                <div class="card">
                    <div class="cardheader">
                    <div class="round-card">
                        <a href="cart/index.php?id=<?php echo $data['IdPrinter']; ?>&action=add">
                            <h4>Add</h4>
                        </a>
                    </div>
                    </div>
            <div class="card-image">
                <div class="round-card-image">
                    <img src="img-product/<?php echo $data['GambarPrinter'] ?>" alt="">
                </div>
            </div>
                <div class="card-body">
                        <h4 class="text-title"><?php echo $data['NamaPrinter'] ?></h4>
                        <p class="text-desc"><?php echo $data['SpesifikasiPrinter'] ?></p>
                        <h6 class="text-price"><?php echo 'Rp.' . number_format($data['HargaPrinter']) ?></h6>
                </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</body>
</html>