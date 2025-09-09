
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tahfidz</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Tahfidz</h3>
    <p>Periode: {{ $start }} sampai {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Surat</th>
                <th>Tanggal</th>
                <th>Ayat/Halaman</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $laporan)
                <tr>
                    <td>{{ $laporan->user->name ?? '-' }}</td>
                    <td>{{ $laporan->suratRelasi->nama ?? '-' }}</td>
                    <td>{{ $laporan->tanggal }}</td>
                    <td>{{ $laporan->ayat_halaman }}</td>
                    <td>{{ $laporan->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
