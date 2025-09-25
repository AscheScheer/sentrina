<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3">
            {{ $kelompoks->links() }}

            @if (auth()->guard('admin')->check())
            <div class="flex flex-row gap-2 mb-2">
                <a href="{{ route('admin.kelompoks.create') }}">
                    <button class="btn btn-primary font-bold px-4 py-2">
                        Tambah Kelompok
                    </button>
                </a>
            </div>
            @endif
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

        @if ($kelompoks->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            Data kelompok belum tersedia!
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container mb-4">
            <thead class="text-sm text-gray-700 uppercase dark:bg-gray-800" style="background-color: #cad7ed;">
                <tr class="border-t border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama Kelompok</th>
                    <th class="px-6 py-3 text-center">Jumlah Anggota</th>
                    <th class="px-6 py-3 text-center">Tanggal Dibuat</th>
                    @if (auth()->guard('admin')->check())
                    <th class="px-6 py-3 text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($kelompoks as $kelompok)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50" style="color: black;">
                    <td class="px-6 py-3 text-center">
                        {{ $loop->iteration + ($kelompoks->currentPage() - 1) * $kelompoks->perPage() }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <a href="{{ route('admin.kelompoks.show', $kelompok->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                            {{ $kelompok->nama }}
                        </a>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                            {{ $kelompok->users_count }} Siswa
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ \Carbon\Carbon::parse($kelompok->created_at)->format('d M Y') }}
                    </td>
                    @if (auth()->guard('admin')->check())
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="{{ route('admin.kelompoks.show', $kelompok->id) }}" class="text-green-600 hover:text-green-900">Detail</a>
                        <a href="{{ route('admin.kelompoks.edit', $kelompok->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.kelompoks.destroy', $kelompok->id) }}" method="POST"
                            style="display:inline-block;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelompok ini? Pastikan tidak ada user yang tergabung.');">
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
