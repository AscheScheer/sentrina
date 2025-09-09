<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-xl mx-auto bg-white p-5 rounded shadow">
        <h2 class="text-2xl font-bold mb-5">Edit Laporan</h2>

        <form action="{{ route('staff.laporan.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- User -->
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 font-bold mb-2">Nama Santri</label>
                <select name="user_id" id="user_id" class="w-full px-3 py-2 border rounded" required>
                    <option disabled selected>-- Pilih Santri --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $laporan->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Surat -->
            <div class="mb-4">
                <label for="surat_id" class="block text-gray-700 font-bold mb-2">Surat</label>
                <select name="surat_id" id="surat_id" class="w-full px-3 py-2 border rounded" required>
                    <option disabled selected>-- Pilih Surat --</option>
                    @foreach ($surat as $s)
                        <option value="{{ $s->id }}" {{ $laporan->surat_id == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Ayat / Halaman -->
            <div class="mb-4">
                <label for="ayat_halaman" class="block text-gray-700 font-bold mb-2">Ayat / Halaman</label>
                <input type="text" name="ayat_halaman" id="ayat_halaman" value="{{ $laporan->ayat_halaman }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <!-- Tanggal -->
            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 font-bold mb-2">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ $laporan->tanggal }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-bold mb-2">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="w-full px-3 py-2 border rounded">{{ $laporan->keterangan }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Simpan</button>
            <a href="{{ route('staff.laporan.index') }}" class="ml-3 text-gray-700 hover:underline">Batal</a>
        </form>
    </div>
</body>
</html>
