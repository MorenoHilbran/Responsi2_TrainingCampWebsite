<?php
session_start();  // Start the session

// Destroy the session to log out the user
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: home.php");
exit();
?>