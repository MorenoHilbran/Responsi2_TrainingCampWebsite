<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../view/style.css">
    <style>
        .iconprofile {
        position: absolute;
        top: 10px;
        right: 10px;
    }
      
    .content {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            margin: 50px;
            gap: 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .team-logo {
            width: 591px;
            height: 543px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .team-logo img {
            width: 100%;
            height: 100%;
        }

        .team-details {
            max-width: 600px;
        }

        .team-details h1 {
            color: #542582;
            font-size: 55px;
            margin-bottom: 50px;
        }

        .team-details ul {
            list-style: disc;
            margin-left: 20px;
            padding: 0;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">NBA</div>
        <ul>
            <li><a href="../view/home2.php">Home</a></li>
            <li><a href="../view/training2.php">Training</a></li>
            <li><a href="../view/teamprofile2.php" class="active">Team Profile</a></li>
            <li><a href="../view/profile.php" class="iconprofile"><img src="../Assets/profile.png" alt="Profile Icon"></a></li>
        </ul>
    </header>

    <div class="content">
        <div class="team-logo">
            <img src="../Assets/LosAnglesLakers.jpg" alt="LAL Logo">
        </div>
        <div class="team-details">
            <h1>Los Angeles Lakers</h1>
            <ul>
                <li><strong>17 Gelar NBA:</strong> (1949–2020), termasuk era dominasi bersama Magic Johnson dan Kobe Bryant.  </li>
                <li><strong>Bintang Legendaris:</strong> Kareem Abdul-Jabbar, Shaquille O'Neal, Kobe Bryant, dan LeBron James.  </li>
                <li><strong>Phil Jackson:</strong> Pelatih ikonik dengan 5 gelar bersama Lakers.</li>
                <li><strong>Warisan Besar:</strong> Salah satu tim paling sukses dan terkenal di NBA. </li>
            </ul>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 NBA Training Course. All rights reserved.</p>
    </footer>

</body>
</html>