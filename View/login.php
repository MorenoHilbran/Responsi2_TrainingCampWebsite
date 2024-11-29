<?php
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    include("connect.php");

    // Cek di tabel admin
    $result_admin = mysqli_query($connect, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
    
    if (mysqli_num_rows($result_admin) == 1) {
        $_SESSION['username'] = $username;
        $berhasil = "Berhasil Login sebagai Admin";
        echo "<script>alert('$berhasil');</script>";
        header("Location: TrainingAdmin.php");
        exit;
    }

    // Cek di tabel user
    $result_user = mysqli_query($connect, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    
    if (mysqli_num_rows($result_user) == 1) {
        $_SESSION['username'] = $username;
        $berhasil = "Berhasil Login sebagai User";
        echo "<script>alert('$berhasil');</script>";
        header("Location: Training.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
<div class="container">
        <div class="login">
            <h1>Login</h1>
            <form method="POST" action="login.php">
                <table>
                    <tr>
                        <td>Username : </td>
                        <td><input type="text" name="username" required></td>
                    </tr>
                    <tr>
                        <td>Password : </td>
                        <td><input type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="login" value="Login"></td>
                    </tr>
                </table>
            </form>
            <a href="register.php">Belum memiliki akun?</a>
        </div>

        <div class="images">
            <img src="../Assets/box.png" alt="Login">
        </div>
    </div>
    
    <?php
    if (isset($error)) {
        echo "<script>alert('$error');</script>";
    } 
    ?>


</body>
</html>