@extends('layouts.app')

@section('title', 'Grafik Keuangan')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="font-weight: bold; color: #007bff;">Grafik Pendapatan dan Pengeluaran</h1>

    <!-- Form untuk memilih rentang tanggal -->
    <form id="filterForm" method="GET" action="{{ route('laporan.chart') }}" class="mb-4 p-4 shadow-sm bg-white rounded">
        <div class="row">
            <div class="col-md-5">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" required>
            </div>
            <div class="col-md-5">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    <canvas id="chartPendapatanPengeluaran" style="max-width: 100%; height: 400px;"></canvas>
</div>

<script>
    var ctx = document.getElementById('chartPendapatanPengeluaran').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!}, // array of labels (dates)
            datasets: [
                {
                    label: 'Pendapatan',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: {!! json_encode($pendapatanData) !!} // array of data (pendapatan)
                },
                {
                    label: 'Pengeluaran',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    data: {!! json_encode($pengeluaranData) !!} // array of data (pengeluaran)
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'category' // Format as category if it's a date string
                },
                y: {
                    beginAtZero: true // Start Y-axis at zero
                }
            }
        }
    });
</script>

<style>
    body {
        background-color: #f8f9fa; /* Light background for contrast */
    }

    .container {
        max-width: 1000px; /* Limit the container width */
    }

    /* Form Styling */
    form {
        background-color: #ffffff; /* White background for the form */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow for elevation */
    }

    /* Button Styling */
    .btn-primary {
        background-color: #007bff; /* Bootstrap primary color */
        border: none; /* Remove default border */
        padding: 10px; /* Padding for better touch targets */
        font-size: 1rem; /* Font size */
        transition: background-color 0.3s ease; /* Smooth transition on hover */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    /* Chart Canvas Styling */
    #chartPendapatanPengeluaran {
        margin-top: 20px; /* Space above the chart */
        border: 2px solid #ced4da; /* Light border around the chart */
        border-radius: 5px; /* Rounded corners for the chart */
        background-color: #ffffff; /* White background for the chart */
        padding: 20px;
    }
</style>
@endsection
