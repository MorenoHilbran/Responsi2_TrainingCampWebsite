<?php
session_start();
require 'connect.php';

if (isset($_GET['id_jadwal'])) {
    $id = intval($_GET['id_jadwal']); // Ambil parameter ID dari URL

    // Periksa apakah pengguna sudah login dan memiliki role 'admin'
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }

    // Query untuk mengambil data jadwal berdasarkan id_jadwal
    $sql = "SELECT id_jadwal, nama_latihan, deskripsi, tempat, tanggal, waktu, gambar FROM jadwal WHERE id_jadwal = ?";
    $stmt = $connect->prepare($sql);

    if ($stmt === false) {
        // Jika prepare gagal, tampilkan error
        die('Error preparing statement: ' . $connect->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Periksa apakah eksekusi query berhasil
    if ($stmt->error) {
        die('Error executing query: ' . $stmt->error);
    }

    $stmt->bind_result($id_jadwal, $nama_latihan, $deskripsi, $tempat, $tanggal, $waktu, $gambar);

    // Periksa apakah data ditemukan
    if ($stmt->fetch()) {
        $row = [
            'id_jadwal' => $id_jadwal,
            'nama_latihan' => $nama_latihan,
            'deskripsi' => $deskripsi,
            'tempat' => $tempat,
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'gambar' => $gambar,
        ];
    } else {
        echo "Jadwal tidak ditemukan.";
        exit;
    }

    $stmt->close();

    // Query untuk mengambil data dari tabel detailcamp berdasarkan id_jadwal
    $sql_detailcamp = "SELECT username, email FROM detailcamp WHERE id_jadwal = ?";
    $stmt_detailcamp = $connect->prepare($sql_detailcamp);

    if ($stmt_detailcamp === false) {
        die('Error preparing statement for detailcamp: ' . $connect->error);
    }

    $stmt_detailcamp->bind_param("i", $id);
    $stmt_detailcamp->execute();

    if ($stmt_detailcamp->error) {
        die('Error executing query for detailcamp: ' . $stmt_detailcamp->error);
    }

    $stmt_detailcamp->bind_result($username, $email);

    // Ambil semua data detailcamp
    $detailcamp_data = [];
    while ($stmt_detailcamp->fetch()) {
        $detailcamp_data[] = [
            'username' => $username,
            'email' => $email,
        ];
    }

    $stmt_detailcamp->close();
} else {
    echo "ID tidak diberikan.";
    exit;
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
            background-color: #FE7C45;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 22px;
            border-radius: 15px;
            display: inline-block;
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

        /* Styling untuk tabel */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #FE7C45;
            color: white;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="trainingadmin.php" class="active">Training</a></li>
            <li><a href="profile.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
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

        <!-- Tabel yang menampilkan username dan email dari detailcamp -->
        <h2>Daftar Peserta Latihan</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
            </tr>
            <?php
            // Periksa apakah ada data peserta
            if (!empty($detailcamp_data)) {
                foreach ($detailcamp_data as $row_detailcamp) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row_detailcamp['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_detailcamp['email']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Tidak ada peserta yang terdaftar.</td></tr>";
            }
            ?>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>
</body>
</html>
