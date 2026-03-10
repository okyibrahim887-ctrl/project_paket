@php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Paket_{$filter}.xls");
@endphp
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
        @foreach($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->nama_penerima }}</td>
            <td>{{ $row->no_wa }}</td>
            <td>{{ $row->nama_satpam }}</td>
            <td>{{ $row->status_cod == 1 ? 'COD' : 'Non COD' }}</td>
            <td>{{ $row->harga_cod }}</td>
            <td>{{ $row->catatan }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y H:i') }}</td>
            <td>{{ $row->status_paket == 1 ? 'Selesai' : 'Belum Selesai' }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
