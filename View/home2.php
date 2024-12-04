<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .iconprofile {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="home2.php" class="active">Home</a></li>
            <li><a href="Training2.php">Training</a></li>
            <li><a href="TeamProfile2.php">Team Profile</a></li>
            <li><a href="profile.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
        </ul>
    </header>

    <section class="hero">
        <div class="hero-content">
            <p>Selamat Datang di</p>
            <h1>Training Course</h1>
            <p>
                Program training untuk pemula yang ingin mengembangkan <br>
                kemampuannya dalam dunia basket.
            </p>
            <a href="Training2.php"><button class="btn">Ikuti Pelatihan</button></a>
        </div>
    </section>

    <section class="player">
        <div class="cards-container">
            <h1>Top Players</h1>
            <div class="cards-wrapper">
                <div class="player-card">
                    <img src="../Assets/StevenAdam.jpg" alt="Steven Adams">
                    <div class="description">
                        <h3>Steven Adams</h3>
                        <br>
                        <p>#12 • C<br>
                        <p>New Zealand <img class="flag-icon" src="../Assets/NewZealand.png" alt="New Zealand"></p>
                    </div>
                </div>

                <div class="player-card">
                    <img src="../Assets/BamAdebayo.jpg" alt="Bam Adebayo">
                    <div class="description">
                        <h3>Bam Adebayo</h3>
                        <br>
                        <p>#13 • C/F<br>
                        <p>USA <img class="flag-icon" src="../Assets/USA.png" alt="USA"></p>
                    </div>
                </div>

                <div class="player-card">
                    <img src="../Assets/StephCurry.jpg" alt="Stephen Curry">
                    <div class="description">
                        <h3>Stephen Curry</h3>
                        <br>
                        <p>#30 • G</br>
                        <p>USA <img class="flag-icon" src="../Assets/USA.png" alt="USA"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="profile">
        <div class="logo">
            <img src="../Assets/logo.png" alt="Logo">
        </div>
        <div class="information">
            <h2>National Basketball Association</h2>
            <p>NBA (National Basketball Association) didirikan pada 6 Juni 1946 <br>
                di New York sebagai Basketball Association of America (BAA). <br>
                Pada 1949, BAA bergabung dengan National Basketball League <br>
                (NBL) dan membentuk NBA. Liga ini berkembang pesat pada <br>
                1980-an dengan persaingan ikon seperti Larry Bird dan Magic <br>
                Johnson, lalu semakin mendunia di era 1990-an berkat Michael <br>
                Jordan. Kini, NBA dengan 30 timnya dikenal sebagai liga bola <br>
                basket terbaik di dunia.
            </p>
    </section>

    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>
</body>
</html>
