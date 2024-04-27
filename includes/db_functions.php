<?php
require_once('../db/db_config.php');

function db_connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function db_close($conn) {
    mysqli_close($conn);
}
?>
