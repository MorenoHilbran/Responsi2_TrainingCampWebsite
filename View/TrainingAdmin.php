<?php
session_start();
    // Koneksi ke Database
    include("connect.php");

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

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

    // Delete the rows from the `detailcamp` table that reference this `jadwal`
    $stmt = $connect->prepare("DELETE FROM detailcamp WHERE id_jadwal=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Now, delete the row from the `jadwal` table
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
        .modal {
            display: none; 
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
           
        }
        .modal-content {
            background-color: #fefefe;
            margin: 2% auto;
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
        .card-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            justify-content: center;
            margin-top: 20px;
            }
            
        .card {
            background-color: #F5F7FA;
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            max-width: 1400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
            display: flex;
            }

        .card-image {
            width:300px;
            height: 210px;
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

        .btn-admin {
            background-color: #FF7134;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 24px;
            margin: 4px 2px;
            margin-top: 20px;                
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-detail{
            background-color: #7BFF53;
            float:right;                
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-right:30px;
            color: white;                
            transform: translateY(-50%);
            text-decoration: none;
            }
        .btn-detail:hover{
            background-color: #45FE7C;
            cursor: pointer;
            
        }   
        .btn-edit{
            background-color: #FE7C45;
            float:right;                
            border: none;
            border-radius: 5px;
            padding:5px;
            margin-right:30px;
            color: white;                
            transform: translateY(-50%);
            text-decoration: none;
            display: flex;
            }
        .btn-edit:hover{
            background-color: #e6b313;
            cursor: pointer;
            
        }
        .btn-hapus{
            background-color: #DE5654;
            float:right;                
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-right:30px;
            color: white;                
            transform: translateY(-50%);
            text-decoration: none;
            }
        .btn-hapus:hover{
            background-color: #e6b313;
            cursor: pointer;
            
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

       
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 600px; 
            border-radius: 8px;
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

       
        form {
            display: flex;
            flex-direction: column;
            gap: 5px
        }

        
        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea,
        input[type="file"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%; 
            box-sizing: border-box; 
        }

       .submit {
           background-color: #FF7134;
           color: #fff;
           padding: 10px 20px;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           margin-top: 10px;
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
           transition: background-color 0.3s ease-in-out;
       }
       .submit:hover {
           background-color: #FF8A65;
       }
       .iconprofile {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .nojadwal {
            text-align: center;
            color: #FE7C45;
            font-size: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="TrainingAdmin.php" class="active">Training</a></li>
            <li><a href="login.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
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
                       <a href="TrainingAdmin.php?edit=<?php echo $row['id_jadwal']; ?>" class="btn-edit"><img src="../Assets/edit.png" alt="edit"></a>
                       <a href="detailadmin.php?id_jadwal=<?php echo $row['id_jadwal']; ?>" class="btn-detail">Detail Latihan</a>
                       <a href="TrainingAdmin.php?delete=<?php echo $row['id_jadwal']; ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">Hapus</a>

                   </div>
               </div>
           <?php endwhile; ?>
        </div>
        <?php else: ?>
            <div class=nojadwal>
        <p>Tidak ada jadwal tersedia</p>
            </div>
        <?php endif; ?>
        <button id="myBtn" class="btn-admin">+</button>
    </section>

    <!-- Tombol untuk membuka pop-up -->

    <!-- Pop-up form -->
    <div id="myModal" class="modal" style="<?php echo isset($_GET['edit']) ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <h1>Form Menambah Jadwal Latihan</h1>
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

                <button type="submit" name="<?php echo $id ? 'update' : 'create'; ?>">
                    <?php echo $id ? 'Update' : 'Tambah'; ?>
                </button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>
    
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

</body>
</html>