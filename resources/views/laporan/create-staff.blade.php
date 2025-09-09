<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-4">
        <!-- Form Tambah -->
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-2xl font-bold mb-5">Tambah Laporan Setoran</h2>

            <form action="{{ route('staff.laporan.store') }}" method="POST">
                @csrf

                <!-- Pilih User -->
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 font-bold mb-2">Nama Santri</label>
                    <select name="user_id" id="user_id" class="w-full px-3 py-2 border rounded" required>
                        <option disabled selected>-- Pilih Santri --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Surat -->
                <div class="mb-4">
                    <label for="surat_id" class="block text-gray-700 font-bold mb-2">Surat</label>
                    <select name="surat_id" id="surat_id" class="w-full px-3 py-2 border rounded" required>
                        <option disabled selected>-- Pilih Surat --</option>
                        @foreach ($surat as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ayat / Halaman -->
                <div class="mb-4">
                    <label for="ayat_halaman" class="block text-gray-700 font-bold mb-2">Ayat / Halaman</label>
                    <input type="text" name="ayat_halaman" id="ayat_halaman" value="{{ old('ayat_halaman') }}"
                           class="w-full px-3 py-2 border rounded" required>
                </div>

                <!-- Tanggal -->
                <div class="mb-4">
                    <label for="tanggal" class="block text-gray-700 font-bold mb-2">Tanggal Setoran</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                           class="w-full px-3 py-2 border rounded" required>
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="block text-gray-700 font-bold mb-2">Keterangan (Opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="w-full px-3 py-2 border rounded">{{ old('keterangan') }}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-800">Simpan</button>
                <a href="{{ route('staff.laporan.index') }}"
                   class="ml-3 text-gray-700 hover:underline">Batal</a>
            </form>
        </div>

        <!-- Tabel 5 Laporan Terakhir -->
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-xl font-bold mb-4 text-center">Setoran Terbaru</h2>

            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="border-b">
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Nama</th>
                        <th class="px-3 py-2">Surat</th>
                        <th class="px-3 py-2">Ayat / Halaman</th>
                        <th class="px-3 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestLaporan as $index => $laporan)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-3 py-2">{{ $index + 1 }}</td>
                            <td class="px-3 py-2">{{ $laporan->user->name ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $laporan->suratRelasi->nama ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $laporan->ayat_halaman ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $laporan->tanggal }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-3 py-4 text-gray-500">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
