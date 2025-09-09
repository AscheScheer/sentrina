<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Welcome "{{ Auth::user()->name }}"!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Tabel 5 Laporan Terakhir -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-bold mb-4 text-start">Setoran Terbaru <x-primary-button onclick="toggleForm()" class="ms-4">
                            + Tambah Laporan
                        </x-primary-button></h2>

                    <table class="w-full min-w-full text-sm text-left">
                        <thead>
                            <tr class="border-b bg-gray-100">
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
                                <td colspan="4" class="text-center px-3 py-4 text-gray-500">Belum ada laporan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div id="formLaporan" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-center items-center overflow-auto">
                        <div class="bg-white w-full max-w-xl p-6 rounded shadow-lg relative">
                            <!-- Tombol close di pojok -->
                            <button onclick="toggleForm()"
                                class="absolute top-2 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">
                                &times;
                            </button>

                            <h2 class="text-2xl font-bold mb-5 text-center">Tambah Laporan Setoran</h2>

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
                                    <input type="text" name="ayat_halaman" id="ayat_halaman"
                                        value="{{ old('ayat_halaman') }}" class="w-full px-3 py-2 border rounded" required>
                                </div>

                                <!-- Tanggal -->
                                <div class="mb-4">
                                    <label for="tanggal" class="block text-gray-700 font-bold mb-2">Tanggal Setoran</label>
                                    <input type="date" name="tanggal" id="tanggal"
                                        value="{{ old('tanggal') }}" class="w-full px-3 py-2 border rounded" required>
                                </div>

                                <!-- Keterangan -->
                                <div class="mb-4">
                                    <label for="keterangan" class="block text-gray-700 font-bold mb-2">Keterangan (Opsional)</label>
                                    <textarea name="keterangan" id="keterangan" rows="3"
                                        class="w-full px-3 py-2 border rounded">{{ old('keterangan') }}</textarea>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end gap-3">
                                    <x-primary-button type="button" onclick="toggleForm()" class="bg-gray-300 text-gray-800 hover:bg-gray-400">Batal</x-primary-button>
                                    <x-primary-button type="submit" class="bg-green-600 hover:bg-green-800">Simpan</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<script>
    function toggleForm() {
        const form = document.getElementById('formLaporan');
        form.classList.toggle('hidden');
    }
</script>
</x-app-layout>
