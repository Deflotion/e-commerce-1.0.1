<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/cart.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="round">
                <img src="../image/logo-icon.png" alt="">
            </div>
            <h4>Shop</h4>
        </div>
        <ul class="navbar-item">
            <li class="nav-item">
                <a href="../index.php" class="nav-link active">Home</a>
            </li>
            <li class="nav-item">
                <a href="../order" class="nav-link active">Orders</a>
            </li>
            <?php
                session_start();

                if (isset($_SESSION['status'])) {
                    if ($_SESSION['status'] == 'admin') {
                        // Halaman Admin
                        echo '
                        <li class="nav-item">
                            <a href="../admin/index.php" class="nav-link">Dashboard</a>
                        </li>
                    ';
                    } else {
                        echo '
                        <li class="nav-item">
                            <a href="../logout.php" class="nav-link active">Logout</a>
                        </li>
                    ';
                    }
                } else {
                    echo '
                        <li class="nav-item">
                            <a href="../login/login.php" class="nav-link active">Login</a>
                        </li>
                    ';
                }
            ?>

        </ul>
        <a href="index.php" class="round">
            <img src="../image/icon-cart.png" class="img-cart" alt="">
        </a>
    </nav>
    <?php

        require '../db/koneksi.php';
        // menghubungkan file item
        require '../item.php';

        // cek apakah ada id yang dikirim
        if (isset($_GET['id']) && !isset($_POST['update'])) {
            // query select table printer berdasarkan id
            $sql = 'SELECT * FROM printer_tb WHERE idPrinter=' . $_GET['id'];
            // jalankan query diatas
            $result = mysqli_query($conn, $sql);
            // tampilkan datanya berupa object
            $product = mysqli_fetch_object($result);
            // initialisasi file item sebagai class item
            $item           = new Item();
            $item->id       = $product->idPrinter; // masukan id printer ke dalam item->id
            $item->name     = $product->NamaPrinter; // masukan nama printer ke dalam item->name
            $item->price    = $product->HargaPrinter; // masukan harga printer ke dalam item->price
            $iteminstock    = 10; // masukan stok printer ke dalam iteminstock
            $item->quantity = 1; // masukan quantity printer ke dalam item->quantity

            // jika session cart kosong maka kita isi session cart sebagia array kosong
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            //Periksa produk dalam keranjang
            $index = -1;
            $cart  = unserialize(serialize($_SESSION['cart']));
            // looping data yang data didalam session cart
            for ($i = 0; $i < count($cart); $i++) {
                if ($cart[$i]->id == $_GET['id']) {
                    $index = $i;
                    break;
                }
            }

            if ($index == -1) {
                $_SESSION['cart'][] = $item;
            }
            //$ _SESSION ['cart']: set $ cart sebagai variabel _session
            else {
                if ($cart[$index]->quantity < $iteminstock) {
                    $cart[$index]->quantity++;
                }

                $_SESSION['cart'] = $cart;
            }
        }
        //Menghapus produk dalam keranjang
        if (isset($_GET['index']) && !isset($_POST['update'])) {
            $cart = unserialize(serialize($_SESSION['cart']));
            unset($cart[$_GET['index']]);
            $cart             = array_values($cart);
            $_SESSION['cart'] = $cart;
        }
        // Perbarui jumlah dalam keranjang
        if (isset($_POST['update'])) {
            $arrQuantity = $_POST['quantity'];
            $cart        = unserialize(serialize($_SESSION['cart']));
            for ($i = 0; $i < count($cart); $i++) {
                $cart[$i]->quantity = $arrQuantity[$i];
            }
            $_SESSION['cart'] = $cart;
        }
    ?>
    <div class="container">
        <h2 class="section-title">keranjang Belanja Anda</h2>
        <form method="POST">
            <table id="t01">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
                <?php
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    $cart  = unserialize(serialize($_SESSION['cart']));
                    $s     = 0;
                    $index = 0;
                    for ($i = 0; $i < count($cart); $i++) {
                    $s += $cart[$i]->price * $cart[$i]->quantity;?>
                <tr>
                    <td><?php echo $cart[$i]->id; ?></td>
                    <td><?php echo $cart[$i]->name; ?> </td>
                    <td>Rp.<?php echo number_format($cart[$i]->price); ?></td>
                    <td>
                        <input type="number" class="form-number" min="1" value="<?php echo
                                                                                    $cart[$i]->quantity; ?>" name="quantity[]">
                    </td>
                    <td> Rp.<?php echo number_format(
                                    $cart[$i]->price * $cart[$i]->quantity
                                ); ?> </td>
                    <td style="display: flex;align-items: center;justify-content: center;">
                        <a href="index.php?index=<?php echo $index; ?>" class="btn-danger"
                            onclick="return confirm('Apa Kamu Yakin Ingin Menghapus Ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php $index++;
                    }
                ?>
                <tr>
                    <td colspan="4" style="text-align:right; font-weight:500">
                        <input id="save" type="button" name="update" alt="Save Button">
                        <input type="hidden" name="update">
                    </td>
                    <td colspan="2"> Rp.<?php echo number_format($s); ?> </td>
                </tr>
            </table>
        </form>
        <br>
        <a href="../index.php" class="btn btn-info">Lanjut belanja</a>
        <?php

            if (isset($_SESSION['id_user'])) {
            ?>
        | <a href="checkout.php" class="btn btn-primary">Checkout</a>
        <?php }?>
    </div>
    <?php if (isset($_GET['id']) || isset($_GET['index'])) {
            header('Location: index.php');
    }?>
</body>

</html>