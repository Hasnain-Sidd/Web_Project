<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page (or home page)
header("Location: login.php"); // change login.php if your login page is different
exit();
?>
