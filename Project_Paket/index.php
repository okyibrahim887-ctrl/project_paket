<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Paket</title>
</head>
<script>

navigator.mediaDevices.getUserMedia({ video:true })
.then(function(stream){

document.getElementById("kamera").srcObject=stream;

});

function ambilFoto(){

let video=document.getElementById("kamera");
let canvas=document.getElementById("canvas");

canvas.width=video.videoWidth;
canvas.height=video.videoHeight;

let ctx=canvas.getContext("2d");

ctx.drawImage(video,0,0);

let foto=canvas.toDataURL("image/png");

document.getElementById("fotoBase64").value=foto;

alert("Foto berhasil diambil");

}

</script>
<body>
<link rel="stylesheet" href="assets/styleindex.css">
<div class="header">
  <img src="assets/logo.png" class="logo">
  <h1>LAYANAN DIGITAL BALAI KOTA</h1>
</div>

<div class="container">
<h2>Input Paket</h2>

<form action="Kirim.php" method="POST" enctype="multipart/form-data">

<label>Nama Penerima</label>
<input type="text" name="nama" required>

<label>No WhatsApp</label>
<input type="text" name="no_wa" required>

<label>Nama Satpam</label>
<input type="text" name="nama_satpam" required>

<label>Status Paket</label>
<select name="cod" id="cod" onchange="toggleHarga()">
  <option value="0">Non COD</option>
  <option value="1">COD</option>
</select>

<div id="hargaField">
  <label>Harga COD</label>
  <input type="number" inputmode="number" name="harga_cod" placeholder="masukkan harga">
</div>

<label>Foto Paket</label>

<input type="file" 
name="foto" 
accept="image/*" 
capture="environment">

<button type="submit">Simpan & Kirim WhatsApp</button>

</form>
</div>

<script>
function toggleHarga(){
  let cod = document.getElementById("cod").value;
  document.getElementById("hargaField").style.display =
      cod == "1" ? "block" : "none";
}
</script>

</body>
</html>
