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

$belum = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket WHERE status_paket=0"));

$selesai = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM paket WHERE status_paket=1"));

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
<link rel="stylesheet" href="admin.css">

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

<a href="total_paket.php" style="text-decoration:none;color:inherit;">
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

<a href="paket_blm_konfirmasi.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h4>Paket Belum Terkonfirmasi</h4>
<p><?= $belum['total']; ?></p>
</div>
</a>

<a href="selesai.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h4>Paket Selesai</h4>
<p><?= $selesai['total']; ?></p>
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