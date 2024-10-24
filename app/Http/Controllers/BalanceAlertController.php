<?php

namespace App\Http\Controllers;

use App\Models\BalanceAlert;
use Illuminate\Http\Request;
use App\Models\Reminder; // Ensure you import your Reminder model

class BalanceAlertController extends Controller
{
    public function cancelReminder(Request $request, $id)
    {
        // Find the reminder by ID and delete or mark it as canceled
        $reminder = Reminder::findOrFail($id);
        $reminder->delete(); // or set a 'canceled' status if you prefer

        return redirect()->back()->with('success', 'Pengingat berhasil dibatalkan.');
    }

    public function cancelBalanceAlert(Request $request)
    {
        return redirect()->back()->with('success', 'Peringatan batas saldo berhasil dibatalkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'threshold_amount' => 'required|numeric|min:500000',
        ]);
    
        BalanceAlert::create([
            'threshold_amount' => $request->threshold_amount,
        ]);
    
        return redirect()->back()->with('success', 'Batas keuangan berhasil ditambahkan!');
    }
    
    public function delete($id)
    {
        $alert = BalanceAlert::findOrFail($id);
        $alert->delete();
    
        return redirect()->back()->with('success', 'Batas keuangan berhasil dihapus!');
    }
    
}
