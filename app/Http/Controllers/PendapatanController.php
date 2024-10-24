<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DataUpdatedNotification;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Kategori; // Import model Kategori

class PendapatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendapatan::with('kategori');

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->whereHas('kategori', function ($q) use ($request) {
                    $q->where('nama_kategori', 'like', '%' . $request->search . '%');
                })->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'tanggal_asc':
                    $query->orderBy('tanggal', 'asc');
                    break;
                case 'tanggal_desc':
                    $query->orderBy('tanggal', 'desc');
                    break;
                case 'jumlah_asc':
                    $query->orderBy('jumlah', 'asc');
                    break;
                case 'jumlah_desc':
                    $query->orderBy('jumlah', 'desc');
                    break;
            }
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $pendapatans = $query->paginate(10);
        
        $pendapatans = $query->get();
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pendapatan.index', compact('pendapatans', 'unpaidReminders'));
    }

    public function exportPendapatan()
    {
        // Membuat instance spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Set judul kolom di baris pertama
        $sheet->setCellValue('A1', 'Kategori');
        $sheet->setCellValue('B1', 'Jumlah');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Deskripsi');
    
        // Ambil data dari model Pendapatan
        $pendapatans = Pendapatan::with('kategori')->get();
    
        // Isi data mulai dari baris kedua
        $row = 2;
        foreach ($pendapatans as $pendapatan) {
            $sheet->setCellValue('A' . $row, $pendapatan->kategori->nama_kategori);
            $sheet->setCellValue('B' . $row, $pendapatan->jumlah);
            $sheet->setCellValue('C' . $row, $pendapatan->tanggal);
            $sheet->setCellValue('D' . $row, $pendapatan->deskripsi);
            $row++;
        }
    
        // Set judul sheet
        $sheet->setTitle('Laporan Pendapatan');
    
        // Header untuk file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="pendapatan.xlsx"');
        header('Cache-Control: max-age=0');
    
        // Buat writer dan ekspor ke browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function show($id)
    {
        $pendapatan = Pendapatan::with('kategori')->findOrFail($id); // Mencari pendapatan berdasarkan ID
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pendapatan.show', compact('pendapatan', 'unpaidReminders')); // Mengembalikan view dengan data pendapatan
    }
    
    public function create()
    {
        $kategoris = Kategori::all(); // Ambil semua kategori
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pendapatan.create', compact('kategoris', 'unpaidReminders')); // Kirim kategori ke view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori,id', // Validasi kategori_id
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        Pendapatan::create($validatedData); // Simpan data pendapatan
        return redirect()->route('pendapatan.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(Pendapatan $pendapatan)
    {
        $kategoris = Kategori::all(); // Ambil semua kategori untuk form edit
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pendapatan.edit', compact('pendapatan', 'kategoris', 'unpaidReminders'));
    }

    public function update(Request $request, Pendapatan $pendapatan)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori,id', // Validasi kategori_id
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $pendapatan->update($validatedData); // Update data pendapatan
        return redirect()->route('pendapatan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Pendapatan $pendapatan)
    {
        $pendapatan->delete(); // Hapus pendapatan
        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan berhasil dihapus.');
    }
}
