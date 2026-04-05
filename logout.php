<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();  // removes all session variables
session_destroy();

header("Location: index.html"); // change path if your login page is elsewhere
exit();
?>