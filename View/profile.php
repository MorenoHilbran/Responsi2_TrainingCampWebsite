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
    <link rel="stylesheet" href="style.css">
    <title>Profil Pengguna</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #563A9C;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            font-size:64px;
            color: #FAFAFA;
        }
        .container {
            width: 835px;
            margin: 30px auto;
            padding: 30px;
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
            font-size: 32px;
        }
        .logout-btn {
            background-color: #DE5654;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            width: 50%;
            text-align: center;
            display: block;
            margin-top: 40px;
            margin-left: auto;
            margin-right: auto;
        }
        .logout-btn:hover {
            background-color: #C14443;
        }
        .iconprofile {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .profile-header .profile-user {
            width: 185px;
            height: 185px;
            border-radius: 50%;
            object-fit: cover;
        }
        .data {
            padding-right: 10px;
            padding-bottom: 10px;
            padding-left: 25px;
            padding-top: 10px;
            background-color: #FF6A2C;
            color:#FAFAFA;
            border-radius: 15px;
            font-size:24px;
            font-weight: bold;
            
        }
    </style>
</head>
<body>
<header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="home2.php">Home</a></li>
            <li><a href="training2.php">Training</a></li>
            <li><a href="teamprofile2.php">Team Profile</a></li>
            <li><a href="profile.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
        </ul>
    </header>

    <h1>Profile</h1>

    <div class="container">
        <div class="profile-header">
            <img src="../Assets/profile.png" alt="User Profile Picture" class="profile-user">
            <h1>Welcome, <?php echo $userData['username']; ?></h1>
        </div>

        <div class="profile-info">
            <p class="info-label">Username</p>
            <p class="data"><?php echo $userData['username']; ?></p>
            <p class="info-label">Email</p>
            <p class="data"><?php echo $userData['email']; ?></p>
        </div>

        <!-- Tombol Log Out -->
        <form method="POST">
            <button type="submit" name="logout" class="logout-btn">Log Out</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>

</body>
</html>
