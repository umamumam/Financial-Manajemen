@extends('layouts.app')

@section('title', 'Edit Pengeluaran')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="color: #dc3545; font-weight: bold;">Edit Pengeluaran</h1>
    
    <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $kategori->id == $pengeluaran->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>    
        
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $pengeluaran->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $pengeluaran->tanggal }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $pengeluaran->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100">Perbarui</button>
    </form>
</div>
@endsection
