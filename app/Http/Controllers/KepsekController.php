<?php

namespace App\Http\Controllers;

use App\Models\Kepsek;
use Illuminate\Http\Request;

class KepsekController extends Controller
{
    public function editProfile()
    {
    $kepsek = auth()->guard('kepsek')->user();
    return view('kepsek.profile', ['kepsek' => $kepsek]);
    }
    /**
     * Update profile admin.
     */
    public function updateProfile(Request $request)
    {
        $kepsek = auth()->guard('kepsek')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:kepsek,email,' . $kepsek->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        Kepsek::where('id', $kepsek->id)->update($data);

        return redirect()->route('kepsek.dashboard')
            ->with('success', 'Profil berhasil diperbarui.')
            ->with('show_alert', true);
    }
}
