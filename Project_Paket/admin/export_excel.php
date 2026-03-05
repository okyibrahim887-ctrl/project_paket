<?php
session_start();
include '../koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Paket.xls");

$filter = $_GET['filter'] ?? 'semua';

$where="";
$judul="Semua Data";

if($filter=='hari'){
    $where="WHERE DATE(tanggal)=CURDATE()";
    $judul="Laporan Harian";
}

elseif($_GET['status']=='belum'){
$where="WHERE status_paket=0";
$judul="Paket Belum Diambil";
}

elseif($_GET['status']=='selesai'){
$where="WHERE status_paket=1";
$judul="Paket Sudah Diambil";
}

elseif($filter=='minggu'){
    $where="WHERE YEARWEEK(tanggal)=YEARWEEK(NOW())";
    $judul="Laporan Mingguan";
}

elseif($filter=='bulan'){
    $where="WHERE MONTH(tanggal)=MONTH(NOW())
            AND YEAR(tanggal)=YEAR(NOW())";
    $judul="Laporan Bulanan";
}

elseif($filter=='tahun'){
    $where="WHERE YEAR(tanggal)=YEAR(NOW())";
    $judul="Laporan Tahunan";
}

elseif($filter=='tanggal'){

    if(!empty($_GET['tgl1']) && !empty($_GET['tgl2'])){

        $tgl1=$_GET['tgl1'];
        $tgl2=$_GET['tgl2'];

        $where="WHERE DATE(tanggal)
                BETWEEN '$tgl1' AND '$tgl2'";

        $judul="Laporan $tgl1 s/d $tgl2";
    }
}

$query=mysqli_query($conn,
"SELECT * FROM paket $where ORDER BY id DESC");

echo "
<h2>LAPORAN PEMBUKUAN PAKET</h2>
<h3>$judul</h3>

<table border='1'>

<tr>
<th>No</th>
<th>Nama</th>
<th>WhatsApp</th>
<th>Satpam</th>
<th>Status COD</th>
<th>Harga</th>
<th>Catatan</th>
<th>Tanggal</th>
<th>Status</th>
</tr>
";

$no=1;

while($row=mysqli_fetch_assoc($query)){

$cod=$row['status_cod']==1 ? "COD":"Non COD";

$status=$row['status_paket']==1 ?
"Sudah Diambil":"Belum Diambil";

echo "
<tr>

<td>".$no++."</td>

<td>".$row['nama_penerima']."</td>

<td>".$row['no_wa']."</td>

<td>".$row['nama_satpam']."</td>

<td>".$cod."</td>

<td>".$row['harga_cod']."</td>

<td>".$row['catatan']."</td>

<td>".$row['tanggal']."</td>

<td>".$status."</td>

</tr>
";
}

echo "</table>";
?>