<?php
$conn = mysqli_connect("localhost","root","","db_paket");

$nama = $_POST['nama'];
$wa = $_POST['wa'];
$satpam = $_POST['satpam'];
$cod = $_POST['cod'];
$harga = $_POST['harga'];
$catatan = $_POST['catatan'];

mysqli_query($conn,"INSERT INTO paket 
(nama_penerima,no_wa,nama_satpam,status_cod,harga_cod,catatan)
VALUES
('$nama','$wa','$satpam','$cod','$harga','$catatan')");
?>
