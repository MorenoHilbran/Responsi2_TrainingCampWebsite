<?php
session_start();

    if (isset($_POST['Submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        include("connect.php");
    
        $result = mysqli_query($connect, "INSERT INTO user(username,email, password) VALUES ('$username','$email', '$password')");
        if ($result) {
            header("Location: login.php");
        } else {
            echo "Registrasi gagal: " . mysqli_error($connect);
        }
            
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registerasi Akun</title>
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

        .register {
            background-color: #563A9C;
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register h1 {
            color: #FE7C45;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .register label {
            color: #FE7C45;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
        }

        .register input {
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

        .register input:focus {
            outline: none;
            border-color: #FF8A65;
            box-shadow: 0 0 5px rgba(255, 112, 67, 0.5);
        }

        .register input[type="submit"] {
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
        .register input[type="submit"]:hover {
            background-color: #FF8A65;
        }

        .register a {
            text-align: center;
            color: #FE7C45;
            font-size: 0.9rem;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .register a:hover {
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
        <div class="images">
            <img src="../Assets/box.png" alt="Login">
        </div>

        <div class="register">
            <h1> REGISTRASI USER </h1>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="email">Email Adress</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <input type="submit" name="Submit" value="Daftar">
            </div>
        </form>
        <a href="login.php">Sudah punya akun</a>
        </div>

    </div>
</body>
</html>