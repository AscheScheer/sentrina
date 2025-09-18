<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3">
            {{ $users->links() }}

            @if (auth()->guard('admin')->check())
            <div class="flex flex-row gap-2 mb-2">
                <a href="{{ route('admin.users.create') }}">
                    <button class="btn btn-primary">Tambah User</button>
                </a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    Import User
                </button>
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

        @if ($users->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            Data user belum tersedia!
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container">
            <thead class="text-sm text-gray-700 uppercase dark:bg-gray-800" style="background-color: #cad7ed;">
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
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50" style="color: black;">
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

    <!-- Modal Import User -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import User dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('users.import.store') }}" method="POST" enctype="multipart/form-data" class="p-4 rounded-lg shadow" style="background-color: #f0f4fa; border: 1px solid #b0c4de;">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label font-bold text-gray-700">Pilih File Excel</label>
                            <input type="file" name="file" id="file" class="form-control border-2 border-blue-300 bg-white" required>
                        </div>
                        <button type="submit" class="btn btn-success font-bold px-4 py-2">Import</button>
                    </form>
                    <a href="{{ asset('user_import_template.xlsx') }}" class="btn btn-warning mt-2" download>
                        Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
