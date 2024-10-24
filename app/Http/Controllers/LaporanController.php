<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reminder;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('laporan.index', compact('unpaidReminders'));
    }
    
    public function generate(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
    
        // Mengambil pendapatan dan pengeluaran dalam rentang tanggal
        $pendapatan = Pendapatan::whereBetween('tanggal', [$startDate, $endDate])->get();
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])->get();
    
        // Menghitung total pendapatan dan pengeluaran
        $totalPendapatan = $pendapatan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
    
        // Menghitung saldo bulan lalu
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
    
        $pendapatanBulanLalu = Pendapatan::whereBetween('tanggal', [$previousMonthStart, $previousMonthEnd])->sum('jumlah');
        $pengeluaranBulanLalu = Pengeluaran::whereBetween('tanggal', [$previousMonthStart, $previousMonthEnd])->sum('jumlah');
        
        $saldoBulanLalu = $pendapatanBulanLalu - $pengeluaranBulanLalu;
    
        // Menghitung saldo sekarang
        $saldoSekarang = $totalPendapatan - $totalPengeluaran;
    
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        
        return view('laporan.index', compact('pendapatan', 'pengeluaran', 'totalPendapatan', 'totalPengeluaran', 'unpaidReminders', 'saldoBulanLalu', 'saldoSekarang'));
    }

    public function chart(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
    
        $labels = [];
        $pendapatanData = [];
        $pengeluaranData = [];
    
        // Mendapatkan data per hari dalam rentang waktu
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
    
        foreach ($period as $date) {
            $labels[] = $date->format('Y-m-d');
            $pendapatanData[] = Pendapatan::whereDate('tanggal', $date)->sum('jumlah');
            $pengeluaranData[] = Pengeluaran::whereDate('tanggal', $date)->sum('jumlah');
        }
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('laporan.chart', compact('labels', 'pendapatanData', 'pengeluaranData', 'unpaidReminders'));
    }
    
}
