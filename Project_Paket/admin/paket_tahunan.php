<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// ambil data tahun ini
$data = mysqli_query($conn,"
SELECT * FROM paket 
WHERE YEAR(tanggal)=YEAR(NOW())
ORDER BY tanggal DESC
");

$tahun = date('Y');
?>

<!DOCTYPE html>
<html>
<head>
<title>Paket Tahun Ini</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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

/* logo */
.logo{
  height:60px;
}

/* tombol kembali */
.logout{
  background:#e74c3c;
  color:white;
  padding:10px 20px;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-weight:bold;
  margin-right:60px;
}

.logout:hover{
  background:#c0392b;
}

/* judul */
.judul{
  margin:20px;
}

/* tabel */
.table-container{
  margin:20px;
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
  font-size:14px;
}

td{
  padding:12px;
  border-bottom:1px solid #eee;
  font-size:14px;
}

tr:hover{
  background:#fafafa;
}

/* badge */
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

</style>
</head>

<body>
<div class="header">
  <div class="header-left">
    <img src="../assets/logo.png" class="logo">
    <h1>LAYANAN DIGITAL BALAI KOTA</h1>

</div>
<a href="admin.php">
<button class="logout">← Kembali</button>
</a>
</div>
<div class="table-container">

<div class="table-header">

<div class="table-title">
Data Pembukuan Paket
</div>

<div class="table-buttons">

<button onclick="window.print()" class="btn-cetak">
🖨 Cetak
</button>

<a href="export_excel.php?filter=tahun" class="btn-excel">
📊 Export Excel Tahunan
</a>

</div>

</div>
<table>

<tr>
<th>No</th>
<th>Nama Penerima</th>
<th>No WhatsApp</th>
<th>Satpam</th>
<th>Status COD</th>
<th>Harga COD</th>
<th>Tanggal</th>
<th>Jam</th>
</tr>

<?php 
$no=1;
while($row=mysqli_fetch_assoc($data)){ 

$tgl = strtotime($row['tanggal']);
$tanggal = date('d-m-Y',$tgl);
$jam = date('H:i',$tgl);

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
<?php 
if($row['status_cod']==1){
echo "Rp ".number_format($row['harga_cod'],0,',','.');
}else{
echo "-";
}
?>
</td>

<td><?= $tanggal; ?></td>

<td><?= $jam; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>