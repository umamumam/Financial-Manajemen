<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reminder;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\BalanceAlert;
use Illuminate\Http\Request;

class ReminderController extends Controller
{

    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $reminders = Reminder::whereMonth('reminder_date', $currentMonth)->get();
        $unpaidReminders = Reminder::where('is_paid', false)
            ->whereMonth('reminder_date', $currentMonth)
            ->get();
        $balanceAlerts = BalanceAlert::all();

        // Menghitung total pendapatan dan pengeluaran
        $totalPendapatan = Pendapatan::sum('jumlah');
        $totalPengeluaran = Pengeluaran::sum('jumlah');

        // Menghitung saldo
        $saldo = $totalPendapatan - $totalPengeluaran;

        // Cek peringatan batas keuangan
        foreach ($balanceAlerts as $alert) {
            if ($saldo <= $alert->threshold_amount && !$alert->is_alerted) {
                $alert->is_alerted = true;
                $alert->save();
            }
        }
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('reminders.index', compact('reminders', 'balanceAlerts', 'saldo', 'unpaidReminders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'reminder_date' => 'required|date',
        ]);

        Reminder::create($request->all());
        return redirect()->back()->with('success', 'Pengingat berhasil ditambahkan!');
    }

    public function markAsPaid($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->is_paid = true;
        $reminder->save();

        return redirect()->back()->with('success', 'Peringatan berhasil ditandai sebagai dibayar.');
    }


    public function storeBalanceAlert(Request $request)
    {
        $request->validate([
            'threshold_amount' => 'required|numeric',
        ]);

        BalanceAlert::create([
            'threshold_amount' => $request->threshold_amount,
        ]);

        return redirect()->back()->with('success', 'Batas keuangan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();

        return redirect()->back()->with('success', 'Peringatan berhasil dibatalkan.');
    }

    public function cancelBalanceAlert(Request $request)
    {
        return redirect()->back()->with('success', 'Peringatan batas saldo berhasil dibatalkan.');
    }

    public function markAsUnpaid($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->is_paid = false;
        $reminder->save();

        return redirect()->back()->with('success', 'Status pengingat telah dibatalkan.');
    }
}
