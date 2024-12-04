<?php 
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil role dari session
$role = $_SESSION['role'];
$username = $_SESSION['username'];

// Koneksi ke database (sesuaikan dengan file koneksi Anda)
include("connect.php");

if ($role == 'admin') {
    $query = "SELECT * FROM admin WHERE username = '$username'";
} else {
    $query = "SELECT * FROM user WHERE username = '$username'";
}

$result = mysqli_query($connect, $query);
$userData = mysqli_fetch_assoc($result);

if (!$userData) {
    die("Data pengguna tidak ditemukan.");
}

// Log out process
if (isset($_POST['logout'])) {
    session_destroy();  // Hapus sesi
    header("Location: logout.php");  // Arahkan ke halaman login
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .profile-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
            font-size: 16px;
            color: #555;
        }
        .profile-info p {
            margin: 0;
        }
        .info-label {
            font-weight: bold;
            color: #333;
        }
        .logout-btn {
            background-color: #FF6347;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 20px;
            width: 100%;
            text-align: center;
        }
        .logout-btn:hover {
            background-color: #FF4500;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-header">
        <img src="user-logo.png" alt="User Profile Picture">
        <h1>Welcome, <?php echo $userData['username']; ?></h1>
    </div>

    <div class="profile-info">
        <p><span class="info-label">Username:</span> <?php echo $userData['username']; ?></p>
        <p><span class="info-label">Email:</span> <?php echo $userData['email']; ?></p>
    </div>

    <!-- Tombol Log Out -->
    <form method="POST">
        <button type="submit" name="logout" class="logout-btn">Log Out</button>
    </form>
</div>

<div class="footer">
    <p>© 2024 NBA Training Course. All rights reserved.</p>
</div>

</body>
</html>
