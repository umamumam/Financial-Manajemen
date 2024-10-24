<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Kategori; // Import model Kategori

class PengeluaranController extends Controller
{
    public function index()
    {
        $query = Pengeluaran::with('kategori'); // Ambil pengeluaran dengan kategori

        // Pencarian
        if ($search = request()->get('search')) {
            $query->whereHas('kategori', function ($q) use ($search) {
                $q->where('nama_kategori', 'like', '%' . $search . '%');
            })->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        $startDate = request()->get('start_date');
        $endDate = request()->get('end_date');

        if ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('tanggal', '<=', $endDate);
        }


        // Pengurutan
        if ($sort = request()->get('sort')) {
            switch ($sort) {
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

        $pengeluarans = $query->get(); // Ambil hasil setelah filter dan urutkan
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pengeluaran.index', compact('pengeluarans', 'unpaidReminders'));
    }


    public function create()
    {
        $kategoris = Kategori::all(); // Ambil semua kategori
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pengeluaran.create', compact('kategoris', 'unpaidReminders')); // Kirim kategori ke view
    }

    public function exportPengeluaran()
    {
        // Membuat instance spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul kolom di baris pertama
        $sheet->setCellValue('A1', 'Kategori');
        $sheet->setCellValue('B1', 'Jumlah');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Deskripsi');

        // Ambil data dari model Pengeluaran
        $pengeluarans = Pengeluaran::with('kategori')->get();

        // Isi data mulai dari baris kedua
        $row = 2;
        foreach ($pengeluarans as $pengeluaran) {
            $sheet->setCellValue('A' . $row, $pengeluaran->kategori->nama_kategori);
            $sheet->setCellValue('B' . $row, $pengeluaran->jumlah);
            $sheet->setCellValue('C' . $row, $pengeluaran->tanggal);
            $sheet->setCellValue('D' . $row, $pengeluaran->deskripsi);
            $row++;
        }

        // Set judul sheet
        $sheet->setTitle('Laporan Pengeluaran');

        // Header untuk file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="pengeluaran.xlsx"');
        header('Cache-Control: max-age=0');

        // Buat writer dan ekspor ke browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function show($id)
    {
        $pengeluaran = Pengeluaran::with('kategori')->findOrFail($id); // Mencari pengeluaran berdasarkan ID
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pengeluaran.show', compact('pengeluaran', 'unpaidReminders')); // Mengembalikan view dengan data pengeluaran
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori,id', // Validasi kategori_id
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'batas_anggaran' => 'nullable|numeric|min:0',
        ]);

        Pengeluaran::create($validatedData); // Simpan data pengeluaran
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $kategoris = Kategori::all(); // Ambil semua kategori untuk form edit
        $unpaidReminders = Reminder::where('is_paid', false)->get();
        return view('pengeluaran.edit', compact('pengeluaran', 'kategoris', 'unpaidReminders'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori,id', // Validasi kategori_id
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'batas_anggaran' => 'nullable|numeric|min:0',
        ]);

        $pengeluaran->update($validatedData); // Update data pengeluaran
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete(); // Hapus pengeluaran
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
