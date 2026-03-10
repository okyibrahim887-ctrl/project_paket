<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
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
.header h1{
font-size:20px;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
color: white;
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

/* LOGOUT */
.logout{
background:#e74c3c;
color:white;
padding:15px 25px;
border:none;
border-radius:4px;
cursor:pointer;
font-weight:bold;
}

.logout:hover{
background:#c0392b;
}

.stats{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:15px;
margin: 20px;
}

.card{
background:white;
padding:18px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.08);
transition:0.2s;
}
.card1{
background:skyblue;
padding:18px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.08);
transition:0.2s;
}

.card h4, .card1 h4{
margin:0;
color:#555;
font-size:14px;
}

.card p, .card1 p{
font-size:24px;
font-weight:bold;
margin:8px 0 0 0;
}

.card.active{
background:#2e86de;
color:white;
transform:scale(1.03);
}
.card.active h4 {
    color: #eee;
}

.card1.active{
background:#0057b8;
color:white;
transform:scale(1.03);
}
.card1.active h4 {
    color: #eee;
}

/* Content Container */
.content-container {
    margin: 20px;
}

/* OVERRIDES EXTRAS */
<?php echo $__env->yieldContent('styles'); ?>

.header-actions {
    display: flex;
    gap: 15px;
    align-items: center;
}

@media (max-width: 768px) {
    .header {
        padding: 0 15px;
    }
    .header h1 {
        font-size: 14px;
        white-space: normal;
        text-align: center;
    }
    .logout {
        padding: 8px 12px;
        font-size: 13px;
    }
    .stats {
        grid-template-columns: 1fr 1fr;
    }
    .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .header-actions {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        gap: 10px;
    }
    .filter-form {
        flex-direction: column;
        align-items: stretch !important;
        width: 100%;
        box-sizing: border-box;
    }
    .filter-form label, .filter-form span {
        display: none;
    }
    .table-buttons {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .stats {
        grid-template-columns: 1fr;
    }
    .header h1 {
        display: none;
    }
}

@media  print{
.header{display:none;}
.stats{display:none;}
.logout{display:none;}
.filter-form{display:none !important;}
.table-buttons{display:none !important;}
body{background:white;padding:0;}
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
<div class="header-left">
<img src="<?php echo e(asset('assets/logo.png')); ?>" class="logo">
<h1>LAYANAN DIGITAL BALAI KOTA</h1>
</div>
<div class="header-right">
<a href="<?php echo e(route('logout')); ?>">
<button class="logout">Logout</button>
</a>
</div>
</div>

<div class="stats">
<a href="<?php echo e(route('admin.dashboard')); ?>" style="text-decoration:none;color:inherit;">
<div class="card1 <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
<h4>Paket Hari Ini</h4>
<p><?php echo e($hari ?? 0); ?></p>
</div>
</a>

<a href="<?php echo e(route('admin.mingguan')); ?>" style="text-decoration:none;color:inherit;">
<div class="card <?php echo e(request()->routeIs('admin.mingguan') ? 'active' : ''); ?>">
<h4>Paket Minggu Ini</h4>
<p><?php echo e($minggu ?? 0); ?></p>
</div>
</a>

<a href="<?php echo e(route('admin.bulanan')); ?>" style="text-decoration:none;color:inherit;">
<div class="card <?php echo e(request()->routeIs('admin.bulanan') ? 'active' : ''); ?>">
<h4>Paket Bulan Ini</h4>
<p><?php echo e($bulan ?? 0); ?></p>
</div>
</a>

<a href="<?php echo e(route('admin.belum_konfirmasi')); ?>" style="text-decoration:none;color:inherit;">
<div class="card <?php echo e(request()->routeIs('admin.belum_konfirmasi') ? 'active' : ''); ?>">
<h4>Paket Belum Terkonfirmasi</h4>
<p><?php echo e($belum ?? 0); ?></p>
</div>
</a>

<a href="<?php echo e(route('admin.semua')); ?>" style="text-decoration:none;color:inherit;">
<div class="card <?php echo e(request()->routeIs('admin.semua') ? 'active' : ''); ?>">
<h4>Total Paket</h4>
<p><?php echo e($total_semua ?? 0); ?></p>
</div>
</a>

<a href="<?php echo e(route('admin.selesai')); ?>" style="text-decoration:none;color:inherit;">
<div class="card <?php echo e(request()->routeIs('admin.selesai') ? 'active' : ''); ?>">
<h4>Paket Selesai</h4>
<p><?php echo e($selesai ?? 0); ?></p>
</div>
</a>
</div>

<div class="content-container">
    <?php echo $__env->yieldContent('content'); ?>
</div>

</body>
</html>
<?php /**PATH D:\Xampp\htdocs\laravel_paket\resources\views/layouts/admin.blade.php ENDPATH**/ ?>