<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Tambahkan ini di bagian <head> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts -->
    <!-- pusher -->
    @auth('web')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            }
        });

        // Subscribe to the private channel for the authenticated user
        var channel = pusher.subscribe('private-user.{{ Auth::id() }}');
        channel.bind('App\\Events\\LaporanUpdated', function(data) {
            // Toastr popup
            toastr.success(
                '<b>Ananda</b> ' + data.user_name + ' telah menyelesaikan setoran baru' +
                '<br><b>Surat:</b> ' + data.surat_name +
                '<br><b>Ayat/Halaman:</b> ' + data.ayat_halaman +
                '<br><b>Tanggal:</b> ' + data.tanggal,
                'Notifikasi Laporan', {
                    timeOut: 7000,
                    closeButton: true,
                    progressBar: true,
                    escapeHtml: false
                }
            );

            // Desktop notification
            if (window.Notification && Notification.permission !== "denied") {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        new Notification("Setoran baru!", {
                            body: "Ananda " + data.user_name + " telah menyelesaikan setoran baru\nSurat: " + data.surat_name + "\nAyat/Halaman: " + data.ayat_halaman + "\nTanggal: " + data.tanggal,
                            icon: "/favicon.ico" // Optional: path to your icon
                        });
                    }
                });
            }
        });
    </script>
    @endauth

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bs-primary: #4ade80 !important;
            /* Tailwind green-400 */
        }

        .btn-primary {
            background-color: #379146 !important;
            border-color: #000 !important;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #4ade80 !important;
            /* Lighten on hover (Tailwind green-400) */
            border-color: #000 !important;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-white-50"> <!-- Changed from bg-gray-100 to bg-green-50 -->
        @include('layouts.navigation')


        <!-- Page Heading -->
        @isset($header)
        <header class="bg-gray-100 shadow"> <!-- Changed from bg-white to bg-green-100 -->
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
