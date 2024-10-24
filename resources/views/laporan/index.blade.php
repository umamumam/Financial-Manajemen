@extends('layouts.app')

@section('title', 'Laporan Keuangan')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="font-weight: bold; color: #007bff;">Laporan Keuangan</h1>

    <form action="{{ route('laporan.generate') }}" method="POST" class="p-4 shadow-sm bg-white rounded">
        @csrf
        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Generate Laporan</button>
    </form>

    @if(isset($pendapatan) && isset($pengeluaran))
    <div class="mt-5">
        <h2 class="text-center" style="color: #343a40;">Laporan dari {{ request()->start_date }} hingga {{ request()->end_date }}</h2>
        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card text-black">
                    <div class="card-header">Saldo Bulan Lalu</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp{{ number_format($saldoBulanLalu, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-black">
                    <div class="card-header">Pendapatan</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-black">
                    <div class="card-header">Pengeluaran</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-black">
                    <div class="card-header">Saldo Sekarang</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp{{ number_format($saldoSekarang, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h3 class="text-success">Pendapatan</h3>
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendapatan as $item)
                    <tr>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->deskripsi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="text-end">Total Pendapatan: <strong>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></h4>
        </div>

        <div class="mt-4">
            <h3 class="text-danger">Pengeluaran</h3>
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengeluaran as $item)
                    <tr>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->deskripsi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="text-end">Total Pengeluaran: <strong>Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></h4>
        </div>

        <h4 class="text-end mt-4">Saldo Akhir: <strong>Rp{{ number_format($totalPendapatan - $totalPengeluaran, 0, ',', '.') }}</strong></h4>
        <p>&nbsp;</p>
    </div>
    @endif
</div>

<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 900px;
    }

    /* Styling for Forms */
    form {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    /* Button Styling */
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Table Styling */
    .table {
        margin-top: 20px;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: left;
    }

    .table th {
        background-color: #f1f3f5;
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Responsive Text Alignment */
    .text-end {
        text-align: right;
    }

    .card {
        border: none; /* Menghilangkan border default card */
        border-radius: 10px; /* Membuat sudut card lebih melengkung */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan untuk kedalaman */
        transition: transform 0.3s, box-shadow 0.3s; /* Animasi saat card di-hover */
    }

    .card:hover {
        transform: translateY(-5px); /* Mengangkat card saat di-hover */
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2); /* Menguatkan bayangan saat di-hover */
    }

    .card-header {
        font-weight: bold; 
        text-align: center; 
        font-size: 1.2rem; 
        background-color: #31a5fe; 
        border-bottom: 2px solid #ced4da; 
    }

    .card-title {
        font-size: 1rem; 
        text-align: center; 
        color: #6ab5ff; 
    }

    .card-body {
        padding: 20px; 
    }

</style>
@endsection
