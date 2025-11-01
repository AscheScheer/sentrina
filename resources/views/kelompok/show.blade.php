<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $kelompok->nama }}</h1>
                    <p class="text-gray-600 mt-2">Detail kelompok dan daftar anggota</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.kelompoks.edit', $kelompok->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Edit Kelompok
                    </a>
                    <a href="{{ route('admin.kelompoks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Info Kelompok -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800">Jumlah Anggota</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $users->total() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800">Tanggal Dibuat</h3>
                    <p class="text-lg font-medium text-green-600">{{ \Carbon\Carbon::parse($kelompok->created_at)->format('d M Y') }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-800">Terakhir Update</h3>
                    <p class="text-lg font-medium text-purple-600">{{ \Carbon\Carbon::parse($kelompok->updated_at)->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Daftar Anggota -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Daftar Anggota</h2>

                @if ($users->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada anggota dalam kelompok ini.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Nama</th>
                                <th class="px-6 py-3">NIS</th>
                                <th class="px-6 py-3">Tanggal Bergabung</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->nis }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                        Edit User
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <x-pagination-responsive :paginator="$users" />
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
