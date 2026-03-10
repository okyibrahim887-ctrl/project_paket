@extends('layouts.admin')

@section('styles')
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

.badge-warning{
  color: #f39c12;
  font-weight: bold;
  text-decoration: none;
}

@endsection

@section('content')
<div class="table-container">

<div class="table-header">
<div class="table-title">Data Pembukuan Paket Bulanan</div>
<div class="table-buttons">
<button onclick="window.print()" class="btn-cetak">🖨 Cetak</button>
<a href="{{ route('admin.export', 'bulan') }}" class="btn-excel">📊 Export Excel Bulanan</a>
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

@foreach($data as $index => $row)
@php
    $tgl = \Carbon\Carbon::parse($row->tanggal);
    $tanggal = $tgl->format('d ') . $bulanIndo[$tgl->format('n')] . $tgl->format(' Y');
    $jam = $tgl->format('H:i');
    
    $codText = $row->status_cod == 1 ? "COD" : "Non COD";
    $hargaFormat = number_format($row->harga_cod, 0, ',', '.');
@endphp

<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $row->nama_penerima }}</td>
<td>{{ $row->no_wa }}</td>
<td>{{ $row->nama_satpam }}</td>

<td>
    @if($row->status_cod == 1)
        <span class="badge-cod">COD</span>
    @else
        <span class="badge-noncod">Non COD</span>
    @endif
</td>

<td>
    {{ $row->status_cod == 1 ? "Rp " . number_format($row->harga_cod, 0, ',', '.') : "-" }}
</td>

<td>{{ $tanggal }}</td>
<td>{{ $jam }}</td>

<td>
    @if($row->status_paket == 1)
        <span style="background:#2ecc71;color:white;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">Sudah Diambil</span>
    @else
        <span style="background:#f39c12;color:white;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:bold;">Belum Diambil</span>
    @endif
</td>

<td>
    @if($row->status_paket == 0)
        <a href="{{ route('admin.konfirmasi', ['id' => $row->id, 'status' => '1']) }}">
            <button style="background:#2ecc71;color:white;border:none;padding:6px 12px;border-radius:8px;cursor:pointer;">Konfirmasi</button>
        </a>
    @else
        <a href="{{ route('admin.konfirmasi', ['id' => $row->id, 'status' => '0']) }}">
            <button style="background:#e67e22;color:white;border:none;padding:6px 12px;border-radius:8px;cursor:pointer;">Batalkan</button>
        </a>
    @endif
</td>

<td>
    @if($row->status_paket == 0)
        <a href="{{ route('admin.peringatan', ['id' => $row->id]) }}" style="text-decoration:none;">
            <span class="badge-warning">Peringatan</span>
        </a>
    @else
        -
    @endif
</td>

</tr>
@endforeach

</table>

</div>
@endsection
