<?php
    // Koneksi ke Database
    include("connect.php");

    // Fungsi Tambah Data
    if (isset($_POST['create'])) {
        // Ambil dan sanitasi input pengguna
        $nama_latihan = $_POST['nama_latihan'];
        $deskripsi = $_POST['deskripsi'];
        $tempat = $_POST['tempat'];
        $tanggal = $_POST['tanggal']; // tanggal sudah dalam format yang aman (date)
        $waktu = $_POST['waktu']; // waktu sudah dalam format yang aman (time)
        $gambar = '';
    
        // Validasi dan upload file gambar
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $fileTmp = $_FILES['gambar']['tmp_name'];
            $fileName = $_FILES['gambar']['name'];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    
            // Hanya izinkan tipe file tertentu
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array(strtolower($fileExt), $allowedExtensions)) {
                // Buat nama unik untuk file yang akan di-upload
                $newFileName = uniqid() . '.' . $fileExt;
                $filePath = 'uploads/' . $newFileName;
    
                // Pindahkan file ke folder uploads
                if (move_uploaded_file($fileTmp, $filePath)) {
                    $gambar = $filePath; // Simpan path gambar jika berhasil di-upload
                } else {
                    echo "Gagal meng-upload gambar.";
                    exit;
                }
            } else {
                echo "Format file tidak diizinkan. Hanya file JPG atau PNG yang diperbolehkan.";
                exit;
            }
        }
    
        // Query untuk menambahkan data ke tabel jadwal
        $sql = "INSERT INTO jadwal (nama_latihan, deskripsi, tempat, tanggal, waktu, gambar)
                VALUES ('$nama_latihan', '$deskripsi', '$tempat', '$tanggal', '$waktu', '$gambar')";
        
        if ($connect->query($sql) === TRUE) {
            header("Location: TrainingAdmin.php"); // Redirect setelah data berhasil ditambahkan
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $connect->error;
        }
    }

    // Fungsi Update Data
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama_latihan = $_POST['nama_latihan'];
        $deskripsi = $_POST['deskripsi'];
        $tempat = $_POST['tempat'];
        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu'];
        $gambar = $_POST['existing_gambar'];

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $filename = $_FILES['gambar']['name'];
            $filepath = 'uploads/' . $filename;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $filepath);
            $gambar = $filepath;
        }

        $stmt = $connect->prepare("UPDATE jadwal SET nama_latihan=?, deskripsi=?, tempat=?, tanggal=?, waktu=?, gambar=? WHERE id_jadwal=?");
        $stmt->bind_param("ssssssi", $nama_latihan, $deskripsi, $tempat, $tanggal, $waktu, $gambar, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: TrainingAdmin.php");
        exit;
    }

    // Fungsi Hapus Data
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $stmt = $connect->prepare("DELETE FROM jadwal WHERE id_jadwal=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        header("Location: TrainingAdmin.php");
        exit;
    }

    // Ambil Data untuk Edit
    $id = $nama_latihan = $deskripsi = $tempat = $tanggal = $waktu = $gambar = "";
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];

        $stmt = $connect->prepare("SELECT * FROM jadwal WHERE id_jadwal=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $nama_latihan = $row['nama_latihan'];
            $deskripsi = $row['deskripsi'];
            $tempat = $row['tempat'];
            $tanggal = $row['tanggal'];
            $waktu = $row['waktu'];
            $gambar = $row['gambar'];
        }
        $stmt->close();
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
        /* CSS untuk pop-up */
        .modal {
            display: none; /* Sembunyikan pop-up secara default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="Training.php" class="active">Training</a></li>
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

    <!-- Tombol untuk membuka pop-up -->
    <button id="myBtn">+</button>

    <!-- Pop-up form -->
    <div id="myModal" class="modal" style="<?php echo isset($_GET['edit']) ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="TrainingAdmin.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="nama_latihan">Nama Latihan:</label>
                <input type="text" name="nama_latihan" value="<?php echo $nama_latihan; ?>" required><br>

                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" required><?php echo $deskripsi; ?></textarea><br>

                <label for="tempat">Tempat:</label>
                <input type="text" name="tempat" value="<?php echo $tempat; ?>" required><br>

                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" value="<?php echo $tanggal; ?>" required><br>

                <label for="waktu">Waktu:</label>
                <input type="time" name="waktu" value="<?php echo $waktu; ?>" required><br>

                <label for="gambar">Gambar:</label>
                <input type="file" name="gambar"><br>
                <?php if ($gambar): ?>
                    <img src="<?php echo $gambar; ?>" alt="Gambar" width="100"><br>
                    <input type="hidden" name="existing_gambar" value="<?php echo $gambar; ?>">
                <?php endif; ?>

                <button type="submit" name="<?php echo $id ? 'update' : 'create'; ?>">
                    <?php echo $id ? 'Update' : 'Tambah'; ?>
                </button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript untuk mengatur pop-up
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php
$sql = "SELECT * FROM jadwal";
$result = $connect->query($sql);

if (!$result) {
    die("Query Error: " . $connect->error);
}
?>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <?php $backgroundImage = $row['gambar'] ? $row['gambar'] : 'default-image.jpg'; ?>
        <div class="card" style="background-image: url('<?php echo $backgroundImage; ?>');">
            <h2><?php echo $row['nama_latihan']; ?></h2>
            <p><?php echo $row['deskripsi']; ?></p>
            <p><strong>Tanggal:</strong> <?php echo $row['tanggal']; ?></p>
            <p><strong>Waktu:</strong> <?php echo $row['waktu']; ?></p>
            <p><strong>Tempat:</strong> <?php echo $row['tempat']; ?></p>
            <a href="TrainingAdmin.php?edit=<?php echo $row['id_jadwal']; ?>" class="btn-edit">Edit</a>
            <a href="TrainingAdmin.php?delete=<?php echo $row['id_jadwal']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">Hapus</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Tidak ada jadwal tersedia.</p>
<?php endif; ?>

</body>
</html>