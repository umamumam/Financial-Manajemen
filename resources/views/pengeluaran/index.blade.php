@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="font-weight: bold; color: #007bff;">Daftar Pengeluaran</h1>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    <div class="mb-3">
        <form method="GET" action="{{ route('pengeluaran.index') }}" class="row g-2">
            <div class="col-12 col-md-2">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan kategori atau deskripsi" value="{{ request()->get('search') }}">
            </div>
            <div class="col-12 col-md-2">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Urutkan berdasarkan</option>
                    <option value="tanggal_asc" {{ request()->get('sort') == 'tanggal_asc' ? 'selected' : '' }}>Tanggal (Asc)</option>
                    <option value="tanggal_desc" {{ request()->get('sort') == 'tanggal_desc' ? 'selected' : '' }}>Tanggal (Desc)</option>
                    <option value="jumlah_asc" {{ request()->get('sort') == 'jumlah_asc' ? 'selected' : '' }}>Jumlah (Asc)</option>
                    <option value="jumlah_desc" {{ request()->get('sort') == 'jumlah_desc' ? 'selected' : '' }}>Jumlah (Desc)</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <input type="date" name="start_date" class="form-control" value="{{ request()->get('start_date') }}">
            </div>
            <div class="col-12 col-md-2">
                <input type="date" name="end_date" class="form-control" value="{{ request()->get('end_date') }}">
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
            </div>
            <div class="col-12 col-md-2">
                <a href="{{ route('pengeluaran.index') }}" class="btn btn-danger w-100">Clear Filter</a>
            </div>
        </form>
    </div>

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary"> + Pengeluaran</a>
        <button id="exportBtn" class="btn btn-success">Ekspor Excel</button>
        {{-- <a href="{{ route('pengeluaran.export') }}" class="btn btn-success">Export Excel</a> --}}
    </div>

    <table class="table table-striped table-bordered" id="dataTable">
        <thead class="table-light">
            <tr>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th style="text-align: center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengeluarans as $pengeluaran)
            <tr>
                <td>{{ $pengeluaran->kategori->nama_kategori }}</td>
                <td>{{ number_format($pengeluaran->jumlah, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $pengeluaran->deskripsi }}</td>
                <td style="text-align: center;">
                    <a href="{{ route('pengeluaran.edit', $pengeluaran->id) }}" class="btn btn-link text-primary p-0" title="Edit">
                        <i class="bi bi-pencil-square"></i> <!-- Ikon Edit -->
                    </a>
                    <form action="{{ route('pengeluaran.destroy', $pengeluaran) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger p-0" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?');">
                            <i class="bi bi-trash"></i> <!-- Ikon Hapus -->
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
document.getElementById('exportBtn').addEventListener('click', function() {
    // Ambil data dari tabel
    var wb = XLSX.utils.table_to_book(document.getElementById('dataTable'), {sheet: "Sheet1"});
    
    // Dapatkan worksheet untuk styling
    var ws = wb.Sheets["Sheet1"];
    
    // Styling untuk header
    var headerRange = XLSX.utils.decode_range(ws['!ref']);
    for (let col = headerRange.s.c; col <= headerRange.e.c; col++) {
        let cell = ws[XLSX.utils.encode_cell({c: col, r: 0})]; // Mengambil cell header
        if (cell) {
            cell.s = {
                fill: {fgColor: {rgb: "FFCCCCCC"}}, // Warna latar belakang abu-abu
                font: {bold: true, color: {rgb: "FF000000"}} // Font tebal hitam
            };
        }
    }
    
    // Menulis file Excel
    XLSX.writeFile(wb, 'data_pengeluaran.xlsx');
});
</script>
@endsection
