<?php
session_start();
include 'connect.php';
$id = $_SESSION['username'];
if (isset($_SESSION['username'])) {
    $query = "SELECT * FROM user WHERE username=$id";
    $result = mysqli_query($conection, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/myprofile.css">
        <link rel="stylesheet" href="style.css">
        <title>My Profile</title>
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

    <div class="box">
        <div class="left">
            <h1>PROFILE</h1>
            <label for="" class="label3">Username</label><br>
            <input type="text" class="input3" value="<?php echo htmlspecialchars($row['username']); ?>" readonly>
            <label for="email" class="label2">E-mail</label><br>
            <input type="email" class="input2" value="<?php echo htmlspecialchars($row['email']); ?>" readonly><br>
            
            <button class="signout" onclick="confLogout()">Logout</button>
        </div>
    </div>
    <div class="footer"></div>
    <script>
        function editprofile() {
            window.location.replace('editprofile.php');
        }
        function confLogout() {
            let text = "Are you sure you want to Logout?";
            if (confirm(text) == true) {
                window.location.replace('logout.php');
            } else {
                alert("Logout Canceled");
            }
        }
    </script>
</body>
</html>
