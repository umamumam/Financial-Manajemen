@extends('layouts.app')

@section('title', 'Export Pendapatan')

@section('content')
<h1>Ekspor Data Pendapatan</h1>

<p>Data pendapatan Anda sedang diproses. Silakan tunggu...</p>

<script>
    // Fungsi untuk mendownload file otomatis
    window.onload = function() {
        // Ganti URL di bawah ini dengan rute ekspor Anda
        window.location.href = "{{ route('pendapatan.export') }}";
    };
</script>
@endsection
