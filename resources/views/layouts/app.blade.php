<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css">

</head>

<style>
    /* body {
        background-image: url('{{ asset('hero-bg-light.webp') }}'), linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)); 
        background-size: cover, cover; 
        background-position: center, center; 
        background-repeat: no-repeat, no-repeat;
        font-family: 'Roboto', sans-serif;
        padding-bottom: 60px; 
        margin: 0;
    } */
    body {
        background-image: linear-gradient(rgba(217, 214, 192, 0.9), rgba(240, 248, 255, 0.9));
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;
        font-family: 'Roboto', sans-serif;
        padding-bottom: 60px; 
        margin: 0;
        color: #333;
    }
    /* Navbar Styling */
    nav.navbar {
        background-image: linear-gradient(45deg, #007bff, #0056b3);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }


    .navbar-brand {
        font-weight: bold;
        color: white !important;
        font-size: 1.5rem;
        display: flex; /* Align items in a row */
        align-items: center; /* Center vertically */
        animation: slideIn 0.5s ease-in-out; /* Animation for brand */
    }

    /* Animation for logo and text */
    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateX(-20px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .navbar-brand i {
        transition: transform 0.3s ease; /* Transition for hover effect */
        animation: bounce 1s infinite alternate; /* Animation for logo */
    }

    /* Animation for the logo */
    @keyframes bounce {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-10px);
        }
    }

    /* New shaking effect */
    .navbar-brand:hover i {
        animation: shake 0.5s; /* New shake animation on hover */
    }

    @keyframes shake {
        0% { transform: translate(1px, 1px) rotate(0deg); }
        25% { transform: translate(-1px, -2px) rotate(-1deg); }
        50% { transform: translate(-3px, 0px) rotate(1deg); }
        75% { transform: translate(3px, 2px) rotate(0deg); }
        100% { transform: translate(1px, -1px) rotate(-1deg); }
    }

    /* New rotation effect */
    /* @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    } */

    .navbar-brand:hover {
        animation: rotate 1s; /* New rotation effect on hover */
    }

    .nav-link {
        color: white !important;
        transition: color 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: #ffdd57 !important;
        /* Add hover effect */
    }

    /* Container Padding */
    .container {
        margin-top: 40px;
    }

    /* Card Styling */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    /* Footer Styling */
    footer {
        background-color: #343a40;
        color: rgba(240, 248, 255, 0.9));
        padding: 0;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 10;
    }

    footer p {
        margin: 0;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        margin: auto;
        height: 40vh;
        width: 80vw;
    }

    /* Responsive navbar and content */
    @media (max-width: 768px) {
        nav.navbar {
            padding: 10px 15px;
        }

        .navbar-brand {
            font-size: 1.25rem;
        }

        .nav-link {
            padding-left: 10px;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
    }
    .notification {
        position: relative;
    }

    /* Nav Link Styles */
    .notification .nav-link {
        color: #495057;
        font-weight: 500;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
    }

    .notification .nav-link:hover {
        color: #007bff;
        transform: scale(1.1); /* Add a subtle scaling effect */
    }

    /* Badge Styles */
    .notification .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: #ff5e5e;
        color: white;
        font-size: 0.75rem;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Add some shadow for depth */
    }

    /* Dropdown Menu Styles */
    .dropdown-menu {
        border-radius: 0.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15); /* A deeper shadow */
        animation: fadeIn 0.3s ease; /* Smooth fade-in animation */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Dropdown Item Styles */
    .dropdown-item {
        transition: background-color 0.3s, color 0.3s ease-in-out;
        padding: 12px 20px;
        border-radius: 0.3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-item:hover {
        background-color: #007bff;
        color: white;
    }

    .dropdown-item span.text-muted {
        font-size: 0.85rem;
        font-weight: 300;
    }

    /* Divider Styles */
    .dropdown-divider {
        margin: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        opacity: 0.6; /* Subtle opacity for softer divider */
    }

    /* Placeholder Notification */
    .notification .dropdown-item.text-center {
        font-style: italic;
        padding: 20px;
        color: #888;
    }

    /* Adjustments for icon sizes */
    .notification i {
        margin-right: 8px;
    }


</style>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home" style="margin-left: 30px;">
                <i class="bi bi-coin me-2 fs-2"></i>
                Smart Finance
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav" style="margin-right: 30px;">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pendapatan.index') }}">Pendapatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengeluaran.index') }}">Pengeluaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan.index') }}">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan.chart') }}">Grafik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reminders.index') }}">Peringatan</a>
                    </li>
                </ul>
                <div class="notification">
                    <a href="#" class="nav-link" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-4"></i>
                        <span class="badge" id="notificationCount">{{ $unpaidReminders->count() }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown">
                        @if($unpaidReminders->count() > 0)
                            @foreach ($unpaidReminders as $reminder)
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="/reminders">
                                        <span>🔔 {{ $reminder->title }}</span>
                                        <span class="text-muted small">{{ \Carbon\Carbon::parse($reminder->reminder_date)->format('d M, Y') }}</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li> <!-- Optional: Add divider between items -->
                            @endforeach
                        @else
                            <li>
                                <a class="dropdown-item text-center text-muted" href="#">✨ Tidak ada pengingat baru</a>
                            </li>
                        @endif
                    </ul>
                </div>
                
                
                
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    {{-- <footer>
        <p>&copy; {{ date('Y') }} Keuangan Pribadi. All Rights Reserved.</p>
    </footer> --}}

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
