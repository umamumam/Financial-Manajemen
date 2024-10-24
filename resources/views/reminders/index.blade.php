@extends('layouts.app')
@section('title', 'Peringatan')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4" style="font-weight: bold; color: #007bff;">Pengingat Pembayaran</h2>

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

    <form action="{{ route('reminders.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="title">Judul Pengingat:</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="reminder_date">Tanggal Pengingat:</label>
                    <input type="date" class="form-control" name="reminder_date" required>
                </div>
            </div>
            <div class="col-md-4 col-12 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Tambah Pengingat</button>
            </div>
        </div>
    </form>

    <h3 class="mt-4">Daftar Pengingat</h3>
    <table class="table table-striped mt-3">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Judul Pengingat</th>
                <th>Tanggal Pengingat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reminders as $index => $reminder)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $reminder->title }}</td>
                <td>{{ \Carbon\Carbon::parse($reminder->reminder_date)->format('d-m-Y') }}</td>
                <td>
                    @if(!$reminder->is_paid)
                    <span class="badge bg-warning text-dark">Belum Dibayar</span>
                    @else
                    <span class="badge bg-success">Dibayar</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex">
                        @if(!$reminder->is_paid)
                        <!-- Tombol Tandai sebagai Dibayar -->
                        <form action="{{ route('reminders.markAsPaid', $reminder->id) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @else
                        <!-- Tombol Cancel jika sudah Dibayar -->
                        <form action="{{ route('reminders.markAsUnpaid', $reminder->id) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-undo"></i>
                            </button>
                        </form>
                        @endif
                        &nbsp;
                        <!-- Tombol Hapus tetap ada -->
                        <form action="{{ route('reminders.cancel', $reminder->id) }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    
{{-- ========Peringatan======== --}}

    <h3 class="mt-4">Saldo Anda</h3>
    @php
        // Tentukan warna berdasarkan saldo
        if ($saldo <= 500000) {
            $alertClass = 'alert-danger'; // Merah, jika saldo 500.000 atau kurang
        } elseif ($saldo <= 1000000) {
            $alertClass = 'alert-warning'; // Kuning, jika saldo 1.000.000 atau kurang
        } else {
            $alertClass = 'alert-success'; // Hijau, jika saldo lebih dari 1.000.000
        }
    @endphp
    <p class="alert {{ $alertClass }}">Saldo saat ini: <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></p>
    <h3 class="mt-4">Atur Batas Keuangan</h3>
    <form action="{{ route('balanceAlerts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="threshold_amount">Batas Keuangan (Minimum: Rp 500.000):</label>
            <input type="number" class="form-control" name="threshold_amount" required min="500000">
        </div>
        <button type="submit" class="btn btn-primary w-100 px-2 py-1 mt-2">Set Batas</button>
    </form>

    <h3 class="mt-4">Daftar Batas Keuangan</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Batas Keuangan</th>
                <th>Status Peringatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($balanceAlerts as $index => $alert)
            <tr>
                <td>{{ $index + 1 }}</td> <!-- Nomor Urut -->
                <td>Rp {{ number_format($alert->threshold_amount, 0, ',', '.') }}</td> <!-- Batas Keuangan -->
                <td>
                    @if ($alert->threshold_amount <= 500000)
                        <span class="badge bg-danger">Jangan Banyak Pengeluaran</span>
                    @elseif ($alert->threshold_amount <= 1000000)
                        <span class="badge bg-warning">Belum Diperingatkan</span>
                    @else
                        <span class="badge bg-success">Keuangan Aman</span>
                    @endif
                </td>
                <td>
                    <!-- Aksi Hapus -->
                    <form action="{{ route('balanceAlerts.delete', $alert->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada batas keuangan yang ditetapkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection