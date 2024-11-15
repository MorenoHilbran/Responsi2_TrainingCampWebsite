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
</head>
<body>
    <h1> REGISTRASI USER </h1>
    <form action="register.php" method="POST">
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr><td><input type="submit" name="Submit"></td></tr>
            </table>
        </form>
        <a href="login.php">Sudah punya akun</a>
</body>
</html>