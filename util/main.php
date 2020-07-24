<?php
$app_name='/phpproekt/';

// Get common code
require_once('tags.php');

// Define some common functions
function display_db_error($error_message) {
    global $app_path;
    include $app_name.'errors/db_error.php';
    exit;
}

function display_error($error_message) {
    global $app_path;
    include 'errors/error.php';
    exit;
}

function redirect($url) {
    session_write_close();
    header("Location: " . $url);
    exit;
}

// Start session to store user and cart data
session_start();
?>
