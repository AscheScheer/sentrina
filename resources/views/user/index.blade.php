<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3">


            @if (auth()->guard('admin')->check() || auth()->guard('kepsek')->check())
            <div class="flex flex-row gap-2 mb-2">
                @if (auth()->guard('admin')->check())
                <a href="{{ route('admin.users.create') }}">
                    <button class="btn btn-success font-bold px-4 py-2">
                        Tambah User
                    </button>
                </a>
                <div> <button class="btn btn-success font-bold px-4 py-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import User
                    </button>
                </div>
                @endif

                <div>
                    <!-- Filter Kelompok -->
                    <form method="GET" action="{{ auth()->guard('admin')->check() ? route('admin.users.index') : route('kepsek.users.index') }}" class="flex items-center gap-2">
                        <select name="kelompok_filter" class="form-select border-2 border-gray-300 rounded" onchange="this.form.submit()">
                            <option value="">Semua Kelompok</option>
                            @foreach($kelompoks as $kelompok)
                            <option value="{{ $kelompok->id }}"
                                {{ request('kelompok_filter') == $kelompok->id ? 'selected' : '' }}>
                                {{ $kelompok->nama }}
                            </option>
                            @endforeach
                            <option value="null" {{ request('kelompok_filter') === 'null' ? 'selected' : '' }}>
                                Tanpa Kelompok
                            </option>
                        </select>

                        @if(request('kelompok_filter'))
                        <a href="{{ auth()->guard('admin')->check() ? route('admin.users.index') : route('kepsek.users.index') }}" class="btn btn-outline-secondary btn-sm">
                            Reset
                        </a>
                        @endif
                    </form>
                </div>
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
                    <th class="px-6 py-3 text-center">NIS</th>
                    <th class="px-6 py-3 text-center">Kelompok</th>
                    <th class="px-6 py-3 text-center">Tanggal Daftar</th>
                    @if (auth()->guard('admin')->check())
                    <th class="px-6 py-3 text-center">Action</th>
                    @elseif (auth()->guard('kepsek')->check())
                    <th class="px-6 py-3 text-center">Status</th>
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
                        {{ $user->nis }}
                    <td class="px-6 py-3 text-center">
                        {{ $user->kelompok->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                    </td>
                    @if (auth()->guard('admin')->check())
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
                    @elseif (auth()->guard('kepsek')->check())
                    <td class="px-6 py-3 text-center">
                        <span class="text-gray-500 text-sm">View Only</span>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-center my-4 py-3" style="background-color: #f0f4fa; border-top: 1px solid #b0c4de;">
            <div class="w-100">
                <!-- Mobile: compact pagination -->
                <div class="d-sm-none d-flex align-items-center justify-content-between gap-2 px-3">
                    @if ($users->onFirstPage())
                        <span class="btn btn-light disabled px-3 py-1">Sebelumnya</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-primary px-3 py-1">Sebelumnya</a>
                    @endif

                    <small class="text-muted">Halaman {{ $users->currentPage() }} / {{ $users->lastPage() }}</small>

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-primary px-3 py-1">Berikutnya</a>
                    @else
                        <span class="btn btn-light disabled px-3 py-1">Berikutnya</span>
                    @endif
                </div>

                <!-- Desktop/Tablet: full pagination -->
                <div class="d-none d-sm-block">
                    {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
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
                            <small class="text-muted">Tolong upload sesuai template yang tersedia</small>
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
