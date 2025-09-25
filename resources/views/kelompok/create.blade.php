<x-app-layout>
    <div class="max-w-xl mx-auto bg-white p-5 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">Tambah Kelompok Baru</h2>

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form action="{{ route('admin.kelompoks.store') }}" method="POST">
            @csrf

            <!-- Nama Kelompok -->
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Kelompok</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Contoh: Kelas A, Grup 1, Tim Alpha" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.kelompoks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
