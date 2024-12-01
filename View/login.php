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
        header("Location: Training2.php");
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .login {
            background-color: #563A9C;
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login h1 {
            color: #FE7C45;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .login label {
            color: #FE7C45;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
        }

        .login input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 2px solid #FE7C45;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 1rem;
        }

        .login input:focus {
            outline: none;
            border-color: #FF8A65;
            box-shadow: 0 0 5px rgba(255, 112, 67, 0.5);
        }

        .login input[type="submit"] {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            width: 30%;
            background-color: #FF7043;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
            margin: 0 auto;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .login input[type="submit"]:hover {
            background-color: #FF8A65;
        }

        .login a {
            text-align: center;
            color: #FE7C45;
            font-size: 0.9rem;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .login a:hover {
            text-decoration: underline;
        }

        .images {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #000;
            overflow: hidden;
        }

        .images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <div class="form">
                <div class="form-group">
                    <label for="username"><b>Username</b></label> <br>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password"><b>Password</b></label> <br>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Login">
                </div>
            </div>
        </form>
        <a href="register.php">Belum memiliki akun?</a>
    </div>
    <div class="images">
        <img src="../Assets/box.png" alt="Login" >
    </div>
</div>

    <?php
    if (isset($error)) {
        echo "<script>alert('$error');</script>";
    } 
    ?>
</body>
</html>