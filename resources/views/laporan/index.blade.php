@php
$routelaporan = route('laporan.index');
@endphp
<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div style="overflow-x: auto; white-space: nowrap;" class="mb-3">
            {{ $laporan->links() }}
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
        <form action="{{ route('laporan.index') }}" method="GET" class="flex items-center gap-4 mb-4 px-3">
            <div>
                <label for="tanggal" class="text-sm text-gray-700">Filter Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal"
                    value="{{ request('tanggal') }}"
                    class="border rounded px-2 py-1 text-sm">
                <x-primary-button type="submit" class="ml-2">
                    Filter
                </x-primary-button>
                <x-primary-button type="button" onclick="window.location='{{ $routelaporan }}'" class="ml-2">
                    Reset
                </x-primary-button>
            </div>
        </form>

        @if ($laporan->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            Data laporan belum tersedia!
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container" >
            <thead class="text-sm text-gray-700 uppercase bg-white dark:bg-gray-800">
                <tr class="border-t border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">Surat</th>
                    <th class="px-6 py-3 text-center">Ayat/Halaman</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">
                        {{ $loop->iteration + ($laporan->currentPage() - 1) * $laporan->perPage() }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->user->name ?? 'Error' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->suratRelasi->nama ?? 'Error' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->ayat_halaman }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->keterangan ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="background-color:#cad7ed; padding: 2px; margin-bottom: 20px; border-radius: 0 0 10px 10px; text-align: center;">
        <form action="{{ route('export.pdf') }}" method="get" target="_blank" class="flex items-center gap-4 mt-4 mb-4 px-3">
            <input type="date" name="start_date" class="border rounded px-2 py-1 text-sm" required> <p>Sampai</p>
            <input type="date" name="end_date" class="border rounded px-2 py-1 text-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
            <x-primary-button type="submit">
                Export ke PDF
            </x-primary-button>
        </form>
        </div>

        @endif
    </div>
</x-app-layout>
