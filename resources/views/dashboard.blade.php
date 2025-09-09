<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <x-primary-button class="m-6 ms-3 mb-3">
                    <a href="{{ route('laporan.index') }}">Lihat Semua Laporan</a>
                </x-primary-button>
            </div>
            <div class="p-6 text-gray-900">
                Laporan terbaru dari "{{ Auth::user()->name }}"
            </div>
            <table class="w-full min-w-full text-sm text-left">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Nama</th>
                        <th class="px-3 py-2">Surat</th>
                        <th class="px-3 py-2">Ayat / Halaman</th>
                        <th class="px-3 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestLaporan as $index => $laporan)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $index + 1 }}</td>
                        <td class="px-3 py-2">{{ $laporan->user->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $laporan->suratRelasi->nama ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $laporan->ayat_halaman ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $laporan->tanggal }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center px-3 py-4 text-gray-500">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
