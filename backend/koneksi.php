<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "greenfresh";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die(json_encode(["status"=>"error", "message"=>"Gagal Koneksi Database"]));
}
?>
