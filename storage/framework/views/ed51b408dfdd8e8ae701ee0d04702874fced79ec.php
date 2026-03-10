<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Paket_{$filter}.xls");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Data Paket</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Penerima</th>
            <th>No WhatsApp</th>
            <th>Nama Satpam</th>
            <th>Status COD</th>
            <th>Harga COD</th>
            <th>Catatan</th>
            <th>Tanggal Dibuat</th>
            <th>Status Paket</th>
        </tr>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($index + 1); ?></td>
            <td><?php echo e($row->nama_penerima); ?></td>
            <td><?php echo e($row->no_wa); ?></td>
            <td><?php echo e($row->nama_satpam); ?></td>
            <td><?php echo e($row->status_cod == 1 ? 'COD' : 'Non COD'); ?></td>
            <td><?php echo e($row->harga_cod); ?></td>
            <td><?php echo e($row->catatan); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($row->tanggal)->format('d-m-Y H:i')); ?></td>
            <td><?php echo e($row->status_paket == 1 ? 'Selesai' : 'Belum Selesai'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</body>
</html>
<?php /**PATH D:\Xampp\htdocs\laravel_paket\resources\views/admin/export_excel.blade.php ENDPATH**/ ?>