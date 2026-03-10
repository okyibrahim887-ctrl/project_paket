<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Paket</title>
</head>

<body>
<link rel="stylesheet" href="<?php echo e(asset('assets/styleindex.css')); ?>">
<div class="header">
  <img src="<?php echo e(asset('assets/logo.png')); ?>" class="logo">
  <h1>LAYANAN DIGITAL BALAI KOTA</h1>
</div>

<div class="container">
<h2>Input Paket</h2>

<?php if(session('success')): ?>
    <script>alert("<?php echo e(session('success')); ?>");</script>
<?php endif; ?>

<?php if(session('error')): ?>
    <script>alert("<?php echo e(session('error')); ?>");</script>
<?php endif; ?>

<!-- Display Validation Errors -->
<?php if($errors->any()): ?>
    <div style="color: red; margin-bottom: 15px;">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('simpan')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<label>Nama Penerima</label>
<input type="text" name="nama" required value="<?php echo e(old('nama')); ?>">

<label>No WhatsApp</label>
<input type="text" name="no_wa" required value="<?php echo e(old('no_wa')); ?>">

<label>Nama Satpam</label>
<input type="text" name="nama_satpam" required value="<?php echo e(old('nama_satpam')); ?>">

<label>Status Paket</label>
<select name="cod" id="cod" onchange="toggleHarga()">
  <option value="0" <?php echo e(old('cod') == '0' ? 'selected' : ''); ?>>Non COD</option>
  <option value="1" <?php echo e(old('cod') == '1' ? 'selected' : ''); ?>>COD</option>
</select>

<div id="hargaField" style="<?php echo e(old('cod') == '1' ? 'display:block;' : 'display:none;'); ?>">
  <label>Harga COD</label>
  <input type="number" inputmode="number" name="harga_cod" placeholder="masukkan harga" value="<?php echo e(old('harga_cod')); ?>">
</div>

<button type="submit">Kirim WhatsApp</button>

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
<?php /**PATH D:\Xampp\htdocs\laravel_paket\resources\views/user/index.blade.php ENDPATH**/ ?>