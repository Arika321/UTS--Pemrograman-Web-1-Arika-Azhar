<?php
header("Content-Type: application/json");
require_once "../koneksi.php";

$id = $_GET['id'] ?? 0;
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // GET DETAIL PRODUK
    case 'GET':
        $sql = $koneksi->query("SELECT * FROM products WHERE id=$id");
        echo json_encode($sql->fetch_assoc());
    break;

    // UPDATE PRODUK
   case 'PUT':
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        echo json_encode(["error" => "Data PUT tidak valid atau kosong"]);
        exit;
    }

    $nama = $data['nama'] ?? "";
    $harga = $data['harga'] ?? "";
    $stok = $data['stok'] ?? "";

    $sql = $koneksi->query("UPDATE products SET
        nama='$nama',
        harga='$harga',
        stok='$stok'
    WHERE id=$id");

    echo json_encode(["status"=>"Produk diupdate"]);
break;


    // HAPUS PRODUK
    case 'DELETE':
        $sql = $koneksi->query("DELETE FROM products WHERE id=$id");
        echo json_encode(["status"=>"Produk dihapus"]);
    break;

    default:
        echo json_encode(["error"=>"Method tidak dikenali"]);
}
?>
