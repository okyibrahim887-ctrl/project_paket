<?php $__env->startSection('styles'); ?>
/* tabel */
.table-container{
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
    background: #22c55e;
    color: white;
    padding: 10px 18px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    display: inline-block;
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

/* filter */
.filter-form {
    display: flex;
    gap: 10px;
    align-items: center;
    background: #f8f9fa;
    padding: 8px 15px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}
.filter-form input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.filter-form button {
    padding: 8px 15px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.filter-form a button {
    background: #95a5a6;
}

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="table-container">

<div class="table-header">
<div class="table-title">Data Pembukuan Semua Paket</div>

<div class="header-actions">
    <form method="GET" class="filter-form" action="<?php echo e(route('admin.dashboard')); ?>">
        <label style="font-size:14px; color:#555; font-weight:bold;">Filter:</label>
        <input type="date" name="tgl1" value="<?php echo e(request('tgl1')); ?>" onchange="this.form.submit()">
        <span style="color:#777;">-</span>
        <input type="date" name="tgl2" value="<?php echo e(request('tgl2')); ?>" onchange="this.form.submit()">
        <a href="<?php echo e(route('admin.dashboard')); ?>"><button type="button" style="background:#e74c3c;">Reset</button></a>
    </form>

    <div class="table-buttons">
    <button onclick="window.print()" class="btn-cetak">🖨 Cetak</button>
    <a href="<?php echo e(route('admin.export', 'semua')); ?>" class="btn-excel">📊 Export Excel</a>
    </div>
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
<th>Status</th>
<th>Aksi</th>
<th>Peringatan</th>
</tr>

<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $tgl = \Carbon\Carbon::parse($row->tanggal);
    $tanggal = $tgl->format('d ') . $bulanIndo[$tgl->format('n')] . $tgl->format(' Y');
    $jam = $tgl->format('H:i');
    
    $codText = $row->status_cod == 1 ? "COD" : "Non COD";
    $hargaFormat = number_format($row->harga_cod, 0, ',', '.');
?>

<tr>
<td><?php echo e($index + 1); ?></td>
<td><?php echo e($row->nama_penerima); ?></td>
<td><?php echo e($row->no_wa); ?></td>
<td><?php echo e($row->nama_satpam); ?></td>

<td>
    <?php if($row->status_cod == 1): ?>
        <span class="badge-cod">COD</span>
    <?php else: ?>
        <span class="badge-noncod">Non COD</span>
    <?php endif; ?>
</td>

<td>
    <?php echo e($row->status_cod == 1 ? "Rp " . number_format($row->harga_cod, 0, ',', '.') : "-"); ?>

</td>

<td><?php echo e($tanggal); ?></td>
<td><?php echo e($jam); ?></td>

<td>
    <?php if($row->status_paket == 1): ?>
        <span style="background:#2ecc71;color:white;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">Sudah Diambil</span>
    <?php else: ?>
        <span style="background:#f39c12;color:white;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">Belum Diambil</span>
    <?php endif; ?>
</td>

<td>
    <?php if($row->status_paket == 0): ?>
        <a href="<?php echo e(route('admin.konfirmasi', ['id' => $row->id, 'status' => '1'])); ?>">
            <button style="background:#2ecc71;color:white;border:none;padding:6px 12px;border-radius:8px;cursor:pointer;">Konfirmasi</button>
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('admin.konfirmasi', ['id' => $row->id, 'status' => '0'])); ?>">
            <button style="background:#e67e22;color:white;border:none;padding:6px 12px;border-radius:8px;cursor:pointer;">Batalkan</button>
        </a>
    <?php endif; ?>
</td>

<td>
    <?php if($row->status_paket == 0): ?>
        <a href="<?php echo e(route('admin.peringatan', ['id' => $row->id])); ?>" style="text-decoration:none;">
            <span class="badge-warning">Peringatan</span>
        </a>
    <?php else: ?>
        -
    <?php endif; ?>
</td>

</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\laravel_paket\resources\views/admin/total_paket.blade.php ENDPATH**/ ?>