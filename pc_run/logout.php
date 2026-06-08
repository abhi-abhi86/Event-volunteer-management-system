<?php
session_start();

// Clear any role sessions
unset($_SESSION['admin_id'], $_SESSION['admin_username']);
unset($_SESSION['volunteer_id']);

session_destroy();

header('Location: index.php');
exit;

