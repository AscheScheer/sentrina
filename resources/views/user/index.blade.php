<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3">
            {{ $users->links() }}
            <a href="{{ route('admin.users.create') }}"
                style="margin-bottom: 10px; display: inline-block;">
                <button class="btn btn-primary">Tambah User</button>
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($users->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            Data user belum tersedia!
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container">
            <thead class="text-sm text-gray-700 uppercase bg-white dark:bg-gray-800">
                <tr class="border-t border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">Email</th>
                    <th class="px-6 py-3 text-center">Tanggal Daftar</th>
                    @if (!auth()->guard('kepsek')->check())
                    <th class="px-6 py-3 text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">
                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                    </td>
                    @if (!auth()->guard('kepsek')->check())
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            style="display:inline-block;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</x-app-layout>
