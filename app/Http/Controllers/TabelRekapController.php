<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TabelRekapController extends Controller
{
    public function index()
    {
        $nisn = Auth::user()->nisn;

        // Ambil data presensi berdasarkan NISN
        $presensi = Kehadiran::where('NISN', $nisn)->get();

        return view('rekap', compact('presensi'));
    }
}
