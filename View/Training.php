<?php
session_start();

$connect = new mysqli("localhost", "root", "", "abn");

if ($connect->connect_error) {
    die("Koneksi gagal: " . $connect    ->connect_error);
}


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
    <style>
    .card-container {
    display: flex;
    flex-direction: column;
    gap: 30px;
    justify-content: center;
    margin-top: 20px;
    }
    
    .card {
    background-color: #FF7134;
    border-radius: 12px;
    overflow: hidden;
    width: 100%;
    max-width: 1300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
    display: flex;
    }

    .card-image {
    width:300px;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    }

    .card-content {
    flex: 1;
    padding: 16px;
    text-align: left;
    margin-left: 20px;
    margin-top:10px;
    }

    .card-content h2 {
    font-size: 25px;
    margin-bottom: 8px;
    }

    .card-content p {
    font-size: 15px;
    margin: 4px 0;
    }

    </style>
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
            
            <?php if ($result->num_rows > 0): ?>
    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img class="card-image" src="<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_latihan']; ?>">
                <div class="card-content">
                    <h2><?php echo $row['nama_latihan']; ?></h2>
                    <p><?php echo $row['deskripsi']; ?></p>
                    <p><strong>Tanggal:</strong> <?php echo $row['tanggal']; ?></p>
                    <p><strong>Waktu:</strong> <?php echo $row['waktu']; ?></p>
                    <p><strong>Tempat:</strong> <?php echo $row['tempat']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Tidak ada jadwal tersedia.</p>
<?php endif; ?>

            
        </section>
</body>
</html>