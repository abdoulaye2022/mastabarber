<?php
function db_connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }
    return $conn;
}
