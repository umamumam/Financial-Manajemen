@extends('layouts.app')

@section('title', 'Detail Pendapatan')

@section('content')
<h1>Detail Pendapatan</h1>
<p><strong>Kategori:</strong> {{ $pendapatan->kategori->nama_kategori }}</p>
<p><strong>Jumlah:</strong> {{ $pendapatan->jumlah }}</p>
<p><strong>Tanggal:</strong> {{ $pendapatan->tanggal }}</p>
<p><strong>Deskripsi:</strong> {{ $pendapatan->deskripsi }}</p>

<a href="{{ route('pendapatan.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
