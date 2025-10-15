<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Statistik Hafalan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Total Juz -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-sm text-gray-600">Jumlah Hafalan:</div>
                        <div class="text-3xl font-bold text-blue-600">{{ $hafalanStats['total_juz_diuji'] }} Juz</div>
                        <div class="text-xs text-gray-500 mt-1">dari 30 Juz</div>
                    </div>
                </div>

                <!-- Progress Hafalan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $hafalanStats['progress_percentage'] }}%</div>
                        <div class="text-sm text-gray-600">Progress Hafalan</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-green-600 h-2 rounded-full progress-bar" data-width="{{ $hafalanStats['progress_percentage'] }}"></div>
                        </div>
                    </div>
                </div>

                <!-- Ujian Bulan Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-orange-600">{{ $hafalanStats['ujian_bulan_ini'] }}</div>
                        <div class="text-sm text-gray-600">Ujian Bulan Ini</div>
                        <div class="text-xs text-gray-500 mt-1">{{ now()->format('F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Setoran Terakhir -->
            @if($latestLaporan->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">📖 Data Setoran Terakhir</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-700">{{ $latestLaporan->first()->suratRelasi->nama ?? '-' }}, {{ $latestLaporan->first()->ayat_halaman ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($latestLaporan->first()->tanggal)->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Laporan Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">📝 Laporan Setoran</h3>
                            <x-primary-button>
                                <a href="{{ route('laporan.index') }}">Lihat Semua</a>
                            </x-primary-button>
                        </div>
                        <div class="text-sm text-gray-600 mb-4">Laporan setoran terbaru:</div>

                        @forelse ($latestLaporan->take(3) as $laporan)
                        <div class="border-l-4 border-blue-400 pl-4 mb-3 bg-gray-50 p-3 rounded-r">
                            <div class="font-medium">{{ $laporan->suratRelasi->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-600">{{ $laporan->ayat_halaman ?? '-' }} • {{ $laporan->tanggal }}</div>
                        </div>
                        @empty
                        <div class="text-center text-gray-500 py-4">Belum ada laporan</div>
                        @endforelse
                    </div>
                </div>

                <!-- Hasil Ujian Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">🎯 Hasil Ujian</h3>
                            <x-primary-button>
                                <a href="{{ route('hasil-ujian.index') }}">Lihat Semua</a>
                            </x-primary-button>
                        </div>
                        <div class="text-sm text-gray-600 mb-4">Ujian terbaru:</div>

                        @forelse ($latestHasilUjian->take(3) as $ujian)
                        <div class="border-l-4 border-green-400 pl-4 mb-3 bg-gray-50 p-3 rounded-r">
                            <div class="font-medium">{{ $ujian->juz }}</div>
                            <div class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($ujian->tanggal)->format('d M Y') }} •
                                Diuji oleh {{ $ujian->staff->name ?? '-' }}
                            </div>
                            @if($ujian->keterangan)
                            <div class="text-xs text-gray-500 mt-1">{{ $ujian->keterangan }}</div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center text-gray-500 py-4">Belum ada ujian</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .grid {
            display: grid;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .gap-4 {
            gap: 1rem;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .space-y-6>*+* {
            margin-top: 1.5rem;
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .progress-bar {
            transition: width 0.3s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                const width = progressBar.getAttribute('data-width');
                progressBar.style.width = width + '%';
            }
        });
    </script>
</x-app-layout>
