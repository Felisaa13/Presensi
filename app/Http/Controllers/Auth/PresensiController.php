<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Presensi;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'Pengguna belum login.');
        }

        // Pastikan NISN pengguna tersedia
        if (is_null($user->nisn)) {
            return back()->with('error', 'NISN pengguna tidak tersedia.');
        }

        // Cek apakah pengguna sudah melakukan check-in hari ini
        $presensi = Kehadiran::where('user_id', $user->id)
            ->whereDate('waktu_datang', now()->toDateString())
            ->first();

        if ($presensi) {
            return back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        Kehadiran::create([
            'NISN' => $user->nisn,
            'user_id' => $user->id,
            'waktu_datang' => now(),
            'waktu_pulang' => null,
            'tanggal' => now()->toDateString()
        ]);

        return back()->with('success', 'Check-in berhasil.');
    }



    public function checkOut(Request $request)
    {
        $userId = Auth::user();

        // Ambil data presensi pengguna hari ini
        $presensi = Kehadiran::where('user_id', $userId->id)
            ->whereDate('waktu_datang', now()->toDateString())
            ->first();

        if (!$presensi || $presensi->waktu_pulang) {
            return back()->with('error', 'Anda belum melakukan check-in atau sudah melakukan check-out.');
        }

        // Simpan waktu check-out
        $presensi->update([
            'waktu_pulang' => now(),
        ]);

        return back()->with('success', 'Check-out berhasil.');
    }
}
