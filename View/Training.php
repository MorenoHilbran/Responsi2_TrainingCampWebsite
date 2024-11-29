<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Koneksi ke database
$connect = new mysqli("localhost", "root", "", "abn");

if ($connect->connect_error) {
    die("Koneksi gagal: " . $connect    ->connect_error);
}

// Ambil data dari tabel jadwal
$sql = "SELECT * FROM jadwal";
$result = $connect  ->query(  $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="Training.php"class="active">Training</a></li>
            <li><a href="TeamProfile.php">Team Profile</a></li>
            <li><a href="login.php" class="login-btn">Login</a></li>
        </ul>
    </header>

        <section class="training">
            <div class="about-training">
            <h1>Exclusive Training</h1>
            <p>Program ini dirancang sebagai pelatihan intensif NBA yang fleksibel dan dapat diadakan di <br>
                berbagai lokasi. Melalui program ini, pelatih profesional dari NBA dapat diundang untuk <br>
                memberikan pelatihan kepada tim atau sekolah secara langsung.</p>
            </div>
            
        <div class="training-images">
            <img src="../Assets/Training1.png" alt="Training">
            <img src="../Assets/Training2.png" alt="Training">
            <img src="../Assets/Training3.png" alt="Training">
            </div>

        </section>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card" style="background-image: url('<?php echo $row['gambar']; ?>');">
                    <h2><?php echo $row['nama_latihan']; ?></h2>
                    <p><?php echo $row['deskripsi']; ?></p>
                    <p><strong>Tanggal:</strong> <?php echo $row['tanggal']; ?></p>
                    <p><strong>Waktu:</strong> <?php echo $row['waktu']; ?></p>
                    <p><strong>Tempat:</strong> <?php echo $row['tempat']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada jadwal tersedia.</p>
        <?php endif; ?>
</body>
</html>