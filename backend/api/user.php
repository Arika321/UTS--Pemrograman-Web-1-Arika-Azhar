<?php
header("Content-Type: application/json");
require_once "../koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    // REGISTER
    $data = json_decode(file_get_contents("php://input"), true);

    $nama = $data['nama'];
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = $koneksi->query("INSERT INTO users (nama, username, password)
        VALUES ('$nama', '$username', '$password')");

    echo json_encode(["status"=>"registrasi berhasil"]);
}

elseif ($method == "GET") {
    // LOGIN
    $username = $_GET['username'];
    $password = $_GET['password'];

    $sql = $koneksi->query("SELECT * FROM users WHERE username='$username'");
    $user = $sql->fetch_assoc();

    if (!$user) {
        echo json_encode(["error"=>"username salah"]);
    } else if (password_verify($password, $user['password'])) {
        echo json_encode(["success"=>true, "nama"=>$user['nama']]);
    } else {
        echo json_encode(["error"=>"password salah"]);
    }
}
?>
