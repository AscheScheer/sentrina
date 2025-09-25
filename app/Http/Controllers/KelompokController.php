<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompoks = Kelompok::withCount('users')->paginate(10);
        return view('kelompok.index', compact('kelompoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelompok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelompoks,nama',
        ]);

        Kelompok::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kelompoks.index')->with('success', 'Kelompok berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelompok $kelompok)
    {
        $users = $kelompok->users()->paginate(10);
        return view('kelompok.show', compact('kelompok', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelompok $kelompok)
    {
        return view('kelompok.edit', compact('kelompok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelompok $kelompok)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelompoks,nama,' . $kelompok->id,
        ]);

        $kelompok->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kelompoks.index')->with('success', 'Kelompok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelompok $kelompok)
    {
        // Check if kelompok has users
        if ($kelompok->users()->count() > 0) {
            return redirect()->route('admin.kelompoks.index')
                ->with('error', 'Tidak dapat menghapus kelompok yang masih memiliki anggota.');
        }

        $kelompok->delete();
        return redirect()->route('admin.kelompoks.index')->with('success', 'Kelompok berhasil dihapus.');
    }
}
