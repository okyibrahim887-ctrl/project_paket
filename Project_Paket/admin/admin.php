<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// =======================
// STATISTIK
// =======================
$total_semua = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket"));

$hari = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket WHERE DATE(tanggal)=CURDATE()"));

$minggu = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket WHERE YEARWEEK(tanggal)=YEARWEEK(NOW())"));

$bulan = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket WHERE MONTH(tanggal)=MONTH(NOW())"));

$tahun = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket WHERE YEAR(tanggal)=YEAR(NOW())"));

// =======================
// FILTER TANGGAL RENTANG
// =======================

$where="";

if(isset($_GET['tgl1']) && isset($_GET['tgl2']) 
&& $_GET['tgl1']!="" && $_GET['tgl2']!=""){

$tgl1=$_GET['tgl1'];
$tgl2=$_GET['tgl2'];

$where="WHERE DATE(tanggal) BETWEEN '$tgl1' AND '$tgl2'";
}

$data = mysqli_query($conn,
"SELECT * FROM paket $where ORDER BY id DESC");

// bulan indonesia
$bulanIndo = [
1=>'Januari','Februari','Maret','April','Mei','Juni',
'Juli','Agustus','September','Oktober','November','Desember'
];
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard Admin Paket</title>
<style>

body{
margin:0;
padding-top:90px;
background:linear-gradient(135deg,#eef2f7,#dce7f3);
font-family:'Segoe UI', sans-serif;
}

/* HEADER */
.header{
position:fixed;
top:0;
left:0;
width:100%;
height:70px;
background:linear-gradient(90deg,#0057b8,#2e86de);
display:flex;
align-items:center;
justify-content:space-between;
padding:0 25px;
box-shadow:0 3px 10px rgba(0,0,0,0.15);
z-index:999;
}

.header-left{
display:flex;
align-items:center;
gap:15px;
}

.header-right{
display:flex;
align-items:center;
gap:10px;
margin-right:40px;
}

.logo{
height:60px;
}
.table-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:10px;
}

.table-title{
font-size:20px;
font-weight:bold;
}

.table-buttons{
display:flex;
gap:10px;
}

/* ukuran tombol lebih pas */
.btn-cetak{
background:#3498db;
color:white;
padding:10px 18px;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:bold;
}

.btn-excel{
background:#22c55e;
color:white;
padding:10px 18px;
text-decoration:none;
border-radius:8px;
font-weight:bold;
}
.btn-excel{
    background: #22c55e;
    color: white;
    padding: 10px 18px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    display: inline-block;
}

/* CETAK */
.btn-cetak{
background:#3498db;
color:white;
padding:15px 25px;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:bold;
}

.btn-cetak:hover{
background:#2c6fd1;
}

/* LOGOUT */
.logout{
background:#e74c3c;
color:white;
padding:15px 25px;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:bold;
}

.logout:hover{
background:#c0392b;
}

/* STAT CARD */
.stats{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:15px;
}

.card{
background:white;
padding:18px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.08);
}
.card1{
background:skyblue;
padding:18px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.card h4{
margin:0;
color:#555;
font-size:14px;
}
.card1 h4{
margin:0;
color:#555;
font-size:14px;
}

.card p{
font-size:24px;
font-weight:bold;
margin:8px 0 0 0;
}
.card1 p{
font-size:24px;
font-weight:bold;
margin:8px 0 0 0;
}

/* TABLE */
.table-container{
margin-top:25px;
background:white;
padding:15px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.08);
overflow:auto;
text-align:center;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#f1f3f7;
padding:12px;
}

td{
padding:12px;
border-bottom:1px solid #eee;
}

/* BADGE */
.badge-cod{
background:#e74c3c;
color:white;
padding:5px 12px;
border-radius:20px;
font-size:12px;
font-weight:bold;
}

.badge-noncod{
background:#2ecc71;
color:white;
padding:5px 12px;
border-radius:20px;
font-size:12px;
font-weight:bold;
}

.badge-warning{
background:#e74c3c;
color:white;
padding:7px 14px;
border-radius:20px;
font-size:12px;
font-weight:bold;
cursor:pointer;
}

/* HEADER CETAK */
.print-header{
display:none;
text-align:center;
margin-bottom:20px;
}

.print-logo{
height:80px;
margin-bottom:10px;
}

.print-title{
font-size:22px;
font-weight:bold;
}

.print-sub{
font-size:16px;
margin-bottom:10px;
}
/* RESPONSIVE HP */
@media (max-width:768px){

/* Container full */
.container{
width:100%;
padding:8px;
box-sizing:border-box;
}


/* CARD tetap 1 baris */
.card-wrapper{
display:flex;
gap:5px;
}

.card{
flex:1;
padding:10px;
font-size:12px;
}

.card h3{
font-size:12px;
}

.card h1{
font-size:18px;
}

/* TABEL TANPA SCROLL SAMPING */

table{
width:100%;
border-collapse:collapse;
font-size:11px;
}

th,td{
padding:4px;
word-break:break-word;
}


/* Kolom jadi kecil */
th:nth-child(1),
td:nth-child(1){
width:5%;
}

th:nth-child(2),
td:nth-child(2){
width:20%;
}

th:nth-child(3),
td:nth-child(3){
width:20%;
}

th:nth-child(4),
td:nth-child(4){
width:15%;
}

th:nth-child(5),
td:nth-child(5){
width:10%;
}

th:nth-child(6),
td:nth-child(6){
width:10%;
}

th:nth-child(7),
td:nth-child(7){
width:10%;
}

th:nth-child(8),
td:nth-child(8){
width:10%;
}


/* Input filter kecil */
input{
width:100%;
margin-top:5px;
}

button{
width:100%;
margin-top:5px;
}

}

/* MODE CETAK */
@media print{

.header{
display:none;
}

.stats{
display:none;
}

.btn-cetak{
display:none;
}

.print-header{
display:block;
}

.logout{
display:none;
}

body{
background:white;
padding:0;
}

.table-container{
box-shadow:none;
margin-top:0;
}

}

</style>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>

<!-- HEADER -->
<div class="header">

<div class="header-left">
<img src="../assets/logo.png" class="logo">
<h1>LAYANAN DIGITAL BALAI KOTA</h1>
</div>

<div class="header-right">

<a href="logout.php">
<button class="logout">Logout</button>
</a>

</div>

</div>


<!-- STATISTIK -->
<div class="stats">

<div class="card1">
<h4>Total Paket</h4>
<p><?= $total_semua['total']; ?></p>
</div>
</a>

<a href="paket_harian.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h4>Paket Hari Ini</h4>
<p><?= $hari['total']; ?></p>
</div>
</a>

<a href="paket_mingguan.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h4>Paket Minggu Ini</h4>
<p><?= $minggu['total']; ?></p>
</div>
</a>

<a href="paket_bulanan.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h4>Paket Bulan Ini</h4>
<p><?= $bulan['total']; ?></p>
</div>
</a>

<a href="paket_tahunan.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h4>Paket Tahun Ini</h4>
<p><?= $tahun['total']; ?></p>
</div>
</a>

</div>
<!-- HEADER CETAK -->
<div class="print-header">

<img src="../assets/logo.png" class="print-logo">

<div class="print-title">
LAYANAN DIGITAL BALAI KOTA
</div>

<div class="print-sub">
LAPORAN PEMBUKUAN PAKET
</div>

<hr>

</div>



<!-- TABEL -->
<div class="table-container">

<div class="table-header">

<div class="table-title">
Data Pembukuan Paket
</div>


<!-- FILTER RENTANG TANGGAL -->

<form method="GET" style="display:flex;gap:8px;align-items:center;">

<label>Dari</label>

<input type="date"
name="tgl1"
value="<?= isset($_GET['tgl1'])?$_GET['tgl1']:'' ?>"
style="padding:6px;border-radius:6px;border:1px solid #ccc;">


<label>Sampai</label>

<input type="date"
name="tgl2"
value="<?= isset($_GET['tgl2'])?$_GET['tgl2']:'' ?>"
style="padding:6px;border-radius:6px;border:1px solid #ccc;">


<button type="submit"
style="padding:6px 14px;border:none;background:#2e86de;color:white;border-radius:6px;">
Filter
</button>


<a href="admin.php">
<button type="button"
style="padding:6px 14px;border:none;background:#888;color:white;border-radius:6px;">
Reset
</button>
</a>

</form>


<div class="table-buttons">

<button onclick="window.print()" class="btn-cetak">
🖨 Cetak
</button>

<a href="export_excel.php?filter=tanggal
<?php
if(isset($_GET['tgl1']) && isset($_GET['tgl2'])
&& $_GET['tgl1']!="" && $_GET['tgl2']!=""){

echo "&tgl1=".$_GET['tgl1'].
     "&tgl2=".$_GET['tgl2'];

}else{

echo "&filter=semua";

}
?>" class="btn-excel">

📊 Export Excel

</a>

</div>

</div>
<table>

<tr>
<th>No</th>
<th>Nama</th>
<th>WhatsApp</th>
<th>Satpam</th>
<th>Status COD</th>
<th>Harga</th>
<th>Tanggal</th>
<th>Jam</th>
<th>Status</th>
<th>Aksi</th>
<th>Peringatan</th>
</tr>

<?php 
$no=1;
while($row=mysqli_fetch_assoc($data)){

$tgl=strtotime($row['tanggal']);
$tanggal=date('d ',$tgl).$bulanIndo[date('n',$tgl)].date(' Y',$tgl);
$jam=date('H:i',$tgl);

$codText=$row['status_cod']==1 ? "COD":"Non COD";

$pesan="Halo ".$row['nama_penerima'].
", paket Anda belum diambil dari Pos Satpam di lobby utama.\n".
"Status: ".$codText."\n".
"Harga COD: Rp ".number_format($row['harga_cod'],0,',','.')."\n".
"Tanggal: ".$tanggal." ".$jam."\n".
"Silakan segera diambil.";

$linkWA="https://wa.me/".$row['no_wa']."?text=".urlencode($pesan);
?>

<tr>

<td><?= $no++; ?></td>
<td><?= $row['nama_penerima']; ?></td>
<td><?= $row['no_wa']; ?></td>
<td><?= $row['nama_satpam']; ?></td>

<td>
<?php if($row['status_cod']==1){ ?>
<span class="badge-cod">COD</span>
<?php } else { ?>
<span class="badge-noncod">Non COD</span>
<?php } ?>
</td>

<td>
<?= $row['status_cod']==1 ? "Rp ".number_format($row['harga_cod'],0,',','.') : "-"; ?>
</td>

<td><?= $tanggal; ?></td>

<td><?= $jam; ?></td>

<td>
<?php if($row['status_paket']==1){ ?>
<span style="background:#2ecc71;color:white;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">
Sudah Diambil
</span>
<?php } else { ?>
<span style="background:#f39c12;color:white;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">
Belum Diambil
</span>
<?php } ?>
</td>

<td>

<?php if($row['status_paket']==0){ ?>

<a href="konfirmasi.php?id=<?= $row['id']; ?>&status=1">
<button style="background:#2ecc71;color:white;border:none;padding:6px 12px;border-radius:8px;">
Konfirmasi
</button>
</a>

<?php } else { ?>

<a href="konfirmasi.php?id=<?= $row['id']; ?>&status=0">
<button style="background:#e67e22;color:white;border:none;padding:6px 12px;border-radius:8px;">
Batalkan
</button>
</a>

<?php } ?>

</td>

<td>

<?php if($row['status_paket']==0){ ?>

<a href="<?= $linkWA ?>" target="_blank">
<span class="badge-warning">Peringatan</span>
</a>

<?php } else { ?>

-

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>