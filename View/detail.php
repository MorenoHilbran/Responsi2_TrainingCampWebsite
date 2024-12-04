<?php
session_start();
require 'connect.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id_jadwal'])) {
    $id_jadwal = intval($_GET['id_jadwal']); // Ambil parameter ID dari URL

    // Gunakan prepared statement untuk keamanan
    $sql = "SELECT * FROM jadwal WHERE id_jadwal = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $id_jadwal);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data
    } else {
        echo "Jadwal tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak diberikan.";
    exit;
}

// Variabel untuk status pendaftaran
$terdaftar = false;
$button_text = "Ikuti Latihan";
$button_disabled = false;
$button_color = "#FE7C45"; // Warna default tombol

// Tangani pengecekan status pendaftaran saat pertama kali mengakses halaman
$username = $_SESSION['username']; // Ambil username pengguna dari session

// Cari id_user dan email berdasarkan username di tabel user
$user_query = "SELECT id_user, email FROM user WHERE username = ?";
$user_stmt = $connect->prepare($user_query);
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows > 0) {
    $user_row = $user_result->fetch_assoc();
    $id_user = $user_row['id_user']; // Ambil id_user dari hasil query
    $email = $user_row['email'];     // Ambil email dari hasil query

    // Cek apakah pengguna sudah terdaftar untuk latihan ini
    $check_query = "SELECT * FROM detailcamp WHERE id_jadwal = ? AND username = ?";
    $check_stmt = $connect->prepare($check_query);
    $check_stmt->bind_param("is", $id_jadwal, $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Jika sudah terdaftar, atur status tombol menjadi "Anda sudah terdaftar"
        $terdaftar = true;
        $button_text = "Anda sudah terdaftar";
        $button_disabled = true; // Nonaktifkan tombol
        $button_color = "#45FE7C"; // Ganti warna tombol setelah berhasil
    }
}

// Tangani klik tombol "Ikuti Latihan"
if (isset($_POST['ikuti_latihan']) && !$terdaftar) {
    // Masukkan data ke tabel detailcamp
    $insert_sql = "INSERT INTO detailcamp (id_jadwal, id_user, username, email) VALUES (?, ?, ?, ?)";
    $insert_stmt = $connect->prepare($insert_sql);
    $insert_stmt->bind_param("iiss", $id_jadwal, $id_user, $username, $email);

    if ($insert_stmt->execute()) {
        // Jika berhasil mendaftar, atur status tombol menjadi "Anda sudah terdaftar"
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var button = document.querySelector('.btn-daftar');
                    button.textContent = 'Anda sudah terdaftar';
                    button.disabled = true; // Nonaktifkan tombol setelah pendaftaran berhasil
                    button.style.backgroundColor = '#45FE7C'; // Ganti warna tombol setelah berhasil
                });
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengikuti latihan: " . $insert_stmt->error . "');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jadwal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .iconprofile {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .detail {
            text-align: center;
            padding: 40px 20px;
        }
        .detail h1 {
            color: #FE7C45;
            font-size:50px;
            text-align: center;
            margin-bottom: 30px;
        }
        .detail img {
            width: 962px;
            height: 460px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .detail p {
            font-size:24px;
            text-align: center;
            margin-bottom:10px;
            font-weight:600;
        }
        .btn-daftar {
            background-color: <?php echo $button_color; ?>;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 22px;
            border-radius: 15px;
            display: inline-block;
            cursor: pointer;
        }
        .btn-daftar:hover {
            background-color: rgba(254, 124, 69, 0.8);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }
        .detail-info {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 20px 0;
            padding: 10px;
        }

        .info-item {
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .info-item strong {
            display: block;
            font-size: 28px;
            color: #000;
            margin-bottom: 5px;
        }   
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="home2.php">Home</a></li>
            <li><a href="Training2.php" class="active">Training</a></li>
            <li><a href="TeamProfile2.php">Team Profile</a></li>
            <li><a href="login.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
        </ul>
    </header>

    <section class="detail">
        <!-- Tampilkan data dari database -->
        <h1><?php echo htmlspecialchars($row['nama_latihan']); ?></h1>
        <p> <?php echo htmlspecialchars($row['deskripsi']); ?></p>
        <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_latihan']); ?>" class="detail-image">
        <div class="detail-info">
        <div class="info-item">
            <strong><?php echo htmlspecialchars($row['tempat']); ?></strong>
        </div>
        <div class="info-item">
            <strong><?php echo htmlspecialchars($row['tanggal']); ?></strong>
        </div>
        <div class="info-item">
            <strong><?php echo htmlspecialchars($row['waktu']); ?></strong>
        </div>
    </div>
        <form method="POST">
            <button type="submit" name="ikuti_latihan" class="btn-daftar" <?php if ($button_disabled) echo 'disabled'; ?>><?php echo $button_text; ?></button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>
</body>
</html>
