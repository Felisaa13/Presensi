<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
        ];

        return view('home', compact('widget'));
    }

    public function checkIn(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::now()->toDateString();

        // Periksa apakah pengguna sudah melakukan check-in hari ini
        $existingCheckIn = Presensi::where('user_id', $user_id)
            ->whereDate('check_in_time', $today)
            ->exists();

        if ($existingCheckIn) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi datang hari ini.');
        }

        $time_now = Carbon::now();
        $presensi = Presensi::create([
            'user_id' => $user_id,
            'check_in_time' => $time_now,
        ]);

        if ($presensi) {
            return redirect()->back()->with('success', 'Presensi datang berhasil dicatat.');
        }

        return redirect()->back()->with('error', 'Gagal mencatat presensi.');
    }

    public function checkOut(Request $request)
    {
        try {
            // Cari data presensi hari ini untuk pengguna saat ini
            $presensi = Presensi::where('user_id', Auth::id())
                ->whereDate('check_in_time', now()->toDateString())
                ->first();

            if ($presensi) {
                // Periksa apakah pengguna sudah melakukan check-out hari ini
                if ($presensi->check_out_time) {
                    return back()->with('error', 'Anda sudah melakukan presensi pulang hari ini.');
                }

                // Jika presensi ditemukan, catat waktu check-out
                $presensi->check_out_time = now();
                $presensi->save();

                return back()->with('success', 'Presensi pulang berhasil dicatat.');
            } else {
                // Jika tidak ada data presensi check-in
                return back()->with('error', 'Belum ada presensi datang yang tercatat.');
            }
        } catch (\Exception $e) {
            // Jika ada error, log kesalahan untuk debugging
            \Log::error('Error in checkOut method: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan.');
        }
    }
}
