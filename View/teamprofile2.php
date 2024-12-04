<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Profile</title>
    <link rel="stylesheet" href="styleteam.css">
    <style>
         .iconprofile {
        position: absolute;
        top: 10px;
        right: 10px;
  
    }
    </style>
    </style>
</head>
<body>
<header class="navbar">
    <div class="logo">NBA</div>
    <ul>
        <li><a href="home2.php">Home</a></li>
        <li><a href="Training2.php">Training</a></li>
        <li><a href="TeamProfile2.php" class="active">Team Profile</a></li>
        <li><a href="profile.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
    </ul>
</header>
<section class="team-profile">
    <div class="header-team">
        <span class="line"></span>
        <h1>Team Profile</h1>
        <form id="search" action="" method="GET">
            <div class="search-bar">
                <input type="text" name="searchName" placeholder="Cari tim..."><img src="../Assets/search-icon.png" class="search-icon">
            </div>
        </form>
    </div>

    <!-- Grid Cards -->
    <div id="cards" class="card-container">
        <div class="card" data-name="Golden State Warriors">
            <a href="../Team/teamprofileGSW.php">
            <img src="../Assets/GoldenStateWarriors.jpg" alt="Golden State Warriors">
            </a>
        </div>
        <div class="card" data-name="Los Angeles Lakers">
            <a href="../Team/teamprofileLAL.php">
            <img src="../Assets/LosAnglesLakers.jpg" alt="Los Angeles Lakers">
            </a>
        </div>
        <div class="card" data-name="Denver Nuggets">
            <a href="../Team/teamprofileDEN.php">
            <img src="../Assets/DenverNuggets.png" alt="Denver Nuggets">
            </a>
        </div>
        <div class="card" data-name="Washington Wizards">
            <img src="../Assets/WashingtonWizards.png" alt="Washington Wizards">
        </div>
        <div class="card" data-name="Atlanta Hawks">
            <img src="../Assets/AtlantaHawks.png" alt="Atlanta Hawks">
        </div>
        <div class="card" data-name="Miami Heat">
            <img src="../Assets/MiamiHeatLogo.png" alt="Miami Heat">
        </div>
        <div class="card" data-name="Houston Rockets">
            <img src="../Assets/HoustonRockets.png" alt="Houston Rockets">
        </div>
        <div class="card" data-name="Dallas Mavericks">
            <img src="../Assets/DallasMavericks.png" alt="Dallas Mavericks">
        </div>
        <div class="card" data-name="Memphis Grizzlies">
            <img src="../Assets/MemphisGrizzlies.png" alt="Memphis Grizzlies">
        </div>
    </div>
</section>
<script src="../Scripts/teamprofile.js"></script>


    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>
</body>
</html>
