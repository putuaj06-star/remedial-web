<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "db_lapangan";

/*
 * Kunci enkripsi untuk data lokasi.
 * Ganti dengan kunci rahasia milik sendiri.
 */
$encryption_key = "GANTI_DENGAN_KUNCI_RAHASIA";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>