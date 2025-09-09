<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

<div class="container my-5">
    <div class="border border-dark rounded p-5 bg-white text-center">
        <h2 class="fw-bold text-dark text-decoration-underline mb-4">Welcome Admin!</h2>

        <div class="row justify-content-center">
            <!-- Jumlah User -->
            <div class="col-md-3 mx-2 my-2 border border-dark rounded py-4">
                <div class="display-4 fw-bold text-dark">{{ $jumlahUser }}</div>
                <div class="text-muted">Jumlah User</div>
            </div>

            <!-- Jumlah Staff -->
            <div class="col-md-3 mx-2 my-2 border border-dark rounded py-4">
                <div class="display-4 fw-bold text-dark">{{ $jumlahStaff }}</div>
                <div class="text-muted">Jumlah Staff</div>
            </div>

            <!-- Jumlah Admin -->
            <div class="col-md-3 mx-2 my-2 border border-dark rounded py-4">
                <div class="display-4 fw-bold text-dark">{{ $jumlahAdmin }}</div>
                <div class="text-muted">Jumlah Admin</div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
