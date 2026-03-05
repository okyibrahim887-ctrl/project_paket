<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$no_wa = $_POST['no_wa'];
$cod = $_POST['cod'];
$catatan = $_POST['catatan'];
$nama_satpam = $_POST['nama_satpam'];
$harga_cod = isset($_POST['harga_cod']) ? $_POST['harga_cod'] : 0;

// simpan ke database
$query = "INSERT INTO paket 
(nama_penerima, no_wa, status_cod, harga_cod, catatan, nama_satpam)
VALUES 
('$nama', '$no_wa', '$cod', '$harga_cod', '$catatan', '$nama_satpam')";

mysqli_query($conn, $query);

// format nomor WA 08 → 62
if(substr($no_wa,0,2)=="08"){
    $no_wa = "62".substr($no_wa,1);
}

// pesan WhatsApp
$status_cod_text = ($cod == 1) ? "COD Rp $harga_cod" : "Non COD";

$pesan = "Halo $nama,
Paket Anda telah sampai di lobby utama.
Status: $status_cod_text
Diterima oleh: $nama_satpam
Catatan: $catatan
Silakan segera diambil.";

header("Location: https://wa.me/$no_wa?text=".urlencode($pesan));
exit();
?>
<?php

$nama=$_POST['nama'];
$wa=$_POST['no_wa'];
$satpam=$_POST['nama_satpam'];
$cod=$_POST['cod'];
$harga=$_POST['harga_cod'];
$catatan=$_POST['catatan'];


// =======================
// SIMPAN FOTO
// =======================

$fotoBase64=$_POST['fotoBase64'];

$namaFile="foto_".time().".png";

$path="foto/".$namaFile;

$data=explode(",",$fotoBase64);

file_put_contents($path,base64_decode($data[1]));

// =======================
// PESAN WA
// =======================

$pesan="Halo ".$nama."
%0APaket Anda sudah tiba di lobby utama".
"%0ASatpam : ".$satpam.
"%0AStatus : ".($cod==1?"COD":"Non COD").
"%0AHarga : Rp ".$harga.
"%0ACatatan : ".$catatan;

$link="https://wa.me/".$wa."?text=".$pesan;

header("Location: ".$link);

?>