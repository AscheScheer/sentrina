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

        <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- User -->
            <div class="mb-4 relative">
                <label for="user_search" class="block text-gray-700 font-bold mb-2">Nama Santri</label>
                <input type="text" id="user_search" placeholder="Ketik nama santri untuk mencari..."
                       class="w-full px-3 py-2 border rounded" autocomplete="off" required
                       value="{{ $laporan->user->name ?? '' }}">
                <input type="hidden" name="user_id" id="user_id" value="{{ $laporan->user_id }}" required>

                <!-- Dropdown untuk hasil pencarian -->
                <div id="user_dropdown" class="absolute z-10 w-full bg-white border border-gray-300 rounded-b shadow-lg max-h-60 overflow-y-auto hidden">
                    @foreach ($users as $user)
                        <div class="user-option px-3 py-2 hover:bg-gray-100 cursor-pointer border-b"
                             data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                            <div class="font-medium">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">NIS: {{ $user->nis ?? '-' }}</div>
                        </div>
                    @endforeach
                </div>
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

            <!-- Juz -->
            <div class="mb-4">
                <label for="juz" class="block text-gray-700 font-bold mb-2">Juz</label>
                <input type="text" name="juz" id="juz" value="{{ $laporan->juz }}"
                    class="w-full px-3 py-2 border rounded" placeholder="Masukkan juz (opsional)">
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-bold mb-2">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="w-full px-3 py-2 border rounded">{{ $laporan->keterangan }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Simpan</button>
            <a href="{{ route('admin.laporan.index') }}" class="ml-3 text-gray-700 hover:underline">Batal</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSearch = document.getElementById('user_search');
            const userDropdown = document.getElementById('user_dropdown');
            const userIdInput = document.getElementById('user_id');
            const userOptions = document.querySelectorAll('.user-option');

            // Show dropdown when input is focused
            userSearch.addEventListener('focus', function() {
                userDropdown.classList.remove('hidden');
                filterUsers(''); // Show all users initially
            });

            // Filter users as user types
            userSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterUsers(searchTerm);
                userDropdown.classList.remove('hidden');

                // Clear hidden input if search is cleared
                if (searchTerm === '') {
                    userIdInput.value = '';
                }
            });

            // Handle user selection
            userOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');

                    userSearch.value = userName;
                    userIdInput.value = userId;
                    userDropdown.classList.add('hidden');
                });
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userSearch.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });

            // Filter function
            function filterUsers(searchTerm) {
                userOptions.forEach(option => {
                    const userName = option.getAttribute('data-user-name').toLowerCase();
                    const userText = option.textContent.toLowerCase();

                    if (userName.includes(searchTerm) || userText.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            // Keyboard navigation
            userSearch.addEventListener('keydown', function(e) {
                const visibleOptions = Array.from(userOptions).filter(option =>
                    option.style.display !== 'none'
                );

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (visibleOptions.length > 0) {
                        visibleOptions[0].classList.add('bg-blue-100');
                        visibleOptions[0].focus();
                    }
                }
            });

            // Handle keyboard navigation in dropdown
            userOptions.forEach((option, index) => {
                option.addEventListener('keydown', function(e) {
                    const visibleOptions = Array.from(userOptions).filter(opt =>
                        opt.style.display !== 'none'
                    );
                    const currentIndex = visibleOptions.indexOf(this);

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextIndex = (currentIndex + 1) % visibleOptions.length;
                        this.classList.remove('bg-blue-100');
                        visibleOptions[nextIndex].classList.add('bg-blue-100');
                        visibleOptions[nextIndex].focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevIndex = currentIndex === 0 ? visibleOptions.length - 1 : currentIndex - 1;
                        this.classList.remove('bg-blue-100');
                        visibleOptions[prevIndex].classList.add('bg-blue-100');
                        visibleOptions[prevIndex].focus();
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        });
    </script>
</body>
</html>
