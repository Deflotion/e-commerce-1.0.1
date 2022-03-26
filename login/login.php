<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form method="POST" class="login" action="../login/function.php">
            <?php
                if (isset($_GET['pesan'])) {
                    if ($_GET['pesan'] == "gagal") {
                        echo "<script>alert('Username atau Password Anda salah. Silahkan coba lagi!')</script>";
                    } else if ($_GET['pesan'] == "logout") {
                        echo "<script>alert('Berhasil Logout')</script>";
                    }
                }
            ?>
            <p class = login-text style="font-size: 2rem; font-weight: 800;">Login</p><br>
            <div class = input-group>
                <input type="username" placeholder="Username" name="username" required></input>
            </div>
            <div class = input-group>
                <input type="password" placeholder="Password" name="password" required></input>
            </div>
            <div class = input-group>
                <button type="submit" class="btn-login"name="submit"><a>Login</a></button>
            </div>
                <p class="register-text">Belum punya akun? <a href="../login/register.php">Register</a></p>
        </form>
    </div>

</body>
</html>
