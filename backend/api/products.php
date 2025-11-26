<?php
header("Content-Type: application/json");
require_once "../koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // GET ALL PRODUK
    case 'GET':
        $sql = $koneksi->query("SELECT * FROM products");
        $data = [];
        while ($row = $sql->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    break;

    // TAMBAH PRODUK
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $nama = $data['nama'];
        $deskripsi = $data['deskripsi'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $gambar = $data['gambar'];

        $sql = $koneksi->query("INSERT INTO products (nama, deskripsi, harga, stok, gambar)
                                VALUES ('$nama', '$deskripsi', '$harga', '$stok', '$gambar')");

        echo json_encode(["status"=>"Produk ditambahkan"]);
    break;

    default:
        echo json_encode(["error"=>"Method tidak dikenali"]);
}
?>
