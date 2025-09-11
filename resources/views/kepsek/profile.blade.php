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

        <form action="{{ route('kepsek.profile.update', $kepsek->id) }}" method="POST">
            @csrf


            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $kepsek->name) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $kepsek->email) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <!-- Password (optional) -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 border rounded"
                    placeholder="minimal 6 huruf/angka">
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Tombol -->
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">Simpan</button>
            <a href="{{ route('kepsek.dashboard') }}" class="ml-3 text-gray-700 hover:underline">Batal</a>
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
            @endif
        </form>
    </div>
</body>

</html>
