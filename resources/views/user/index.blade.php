<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Paket</title>
</head>

<body>
<link rel="stylesheet" href="{{ asset('assets/styleindex.css') }}">
<div class="header">
  <img src="{{ asset('assets/logo.png') }}" class="logo">
  <h1>LAYANAN DIGITAL BALAI KOTA</h1>
</div>

<div class="container">
<h2>Input Paket</h2>

@if(session('success'))
    <script>alert("{{ session('success') }}");</script>
@endif

@if(session('error'))
    <script>alert("{{ session('error') }}");</script>
@endif

<!-- Display Validation Errors -->
@if ($errors->any())
    <div style="color: red; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('simpan') }}" method="POST" enctype="multipart/form-data">
@csrf

<label>Nama Penerima</label>
<input type="text" name="nama" required value="{{ old('nama') }}">

<label>No WhatsApp</label>
<input type="text" name="no_wa" required value="{{ old('no_wa') }}">

<label>Nama Satpam</label>
<input type="text" name="nama_satpam" required value="{{ old('nama_satpam') }}">

<label>Status Paket</label>
<select name="cod" id="cod" onchange="toggleHarga()">
  <option value="0" {{ old('cod') == '0' ? 'selected' : '' }}>Non COD</option>
  <option value="1" {{ old('cod') == '1' ? 'selected' : '' }}>COD</option>
</select>

<div id="hargaField" style="{{ old('cod') == '1' ? 'display:block;' : 'display:none;' }}">
  <label>Harga COD</label>
  <input type="number" inputmode="number" name="harga_cod" placeholder="masukkan harga" value="{{ old('harga_cod') }}">
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
