
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-xl mx-auto bg-white p-5 rounded shadow">
        <h2 class="text-2xl font-bold mb-5">Edit User</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <!-- NIS -->
            <div class="mb-4">
                <label for="nis" class="block text-gray-700 font-bold mb-2">NIS</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis', $user->nis) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <!-- kelompok  -->
            <div class="mb-4">
                <label for="kelompok_id" class="block text-gray-700 font-bold mb-2">Kelompok (Opsional)</label>
                <select name="kelompok_id" id="kelompok_id" class="w-full px-3 py-2 border rounded">
                    <option value="">-- Pilih Kelompok --</option>
                    @foreach($kelompoks as $kelompok)
                        <option value="{{ $kelompok->id }}" {{ (old('kelompok_id', $user->kelompok_id) == $kelompok->id) ? 'selected' : '' }}>
                            {{ $kelompok->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Password (optional) -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Tombol -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="ml-3 text-gray-700 hover:underline">Batal</a>
        </form>
    </div>
</body>
</html>
