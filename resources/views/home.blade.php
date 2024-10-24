@extends('layouts.app')
@section('title', 'Home')
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<style>
    body {
        background-color: #f4f4f9;
        font-family: 'Roboto', sans-serif;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .date-container {
        text-align: center;
        font-size: 24px;
        margin-top: 20px;
        color: #0056b3;
    }

    .box-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .box-container img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-top: 10px;
    }

    .btn-calculate,
    .btn-upload {
        background-color: #0056b3;
        color: white;
        width: 100%;
    }

    .calculator-body {
        display: grid;
        grid-template-rows: auto 1fr;
        gap: 10px;
    }

    .calculator-screen {
        padding: 10px;
        background-color: #f0f0f0;
        border-radius: 5px;
    }

    .calculator-buttons .row {
        display: flex;
        justify-content: space-between;
    }

    .calculator-buttons .btn {
        padding: 20px;
        font-size: 20px;
        margin: 5px;
    }

    .calculator-buttons .btn.col {
        flex: 1;
    }

    .date-container, .temperature-container, .location-container {
        font-size: 1.5rem;
        margin-bottom: 10px;
        text-align: center;
    }

    .date-container, .temperature-container, .location-container {
        font-size: 1.2rem;
        color: #343a40;
        margin-bottom: 15px;
    }

    .date-container {
        font-weight: 700;
    }

    .temperature-container {
        color: #ff6b6b;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .location-container {
        color: #1e90ff;
        font-weight: 600;
    }

    @media screen and (max-width: 768px) {
        .container {
            padding: 15px 20px;
        }

        .date-container, .temperature-container, .location-container {
            font-size: 1rem;
        }

        .temperature-container {
            font-size: 1.2rem;
        }
    }

</style>

<body>
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
    <div class="container">
        <!-- Display Current Date -->
        <div class="date-container" id="current-date"></div>
        <div class="temperature-container" id="current-temperature"></div>
        <div class="location-container" id="current-location"></div>


        <!-- Grid Layout -->
        <div class="grid-container">
            <!-- Currency Conversion Section -->
            <div class="box-container currency-container">
                <h4 class="text-center">Currency Converter</h4>
            
                <!-- Pilihan Konversi Mata Uang dari Rupiah ke Mata Uang Asing -->
                <div class="mb-3">
                    <label for="currency" class="form-label">Choose Currency:</label>
                    <input type="text" id="currency-input" class="form-control" placeholder="Type to search currency..." autocomplete="off">
                    <select id="currency-select" class="form-select" size="5" style="display: none;"></select>
                </div>
            
                <!-- Masukan Jumlah yang Ingin Dikonversi -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount:</label>
                    <input type="number" id="amount" class="form-control" placeholder="Enter amount" min="0">
                </div>
            
                <!-- Tombol Tukar Mata Uang -->
                <div class="text-center mb-3">
                    <button id="swap-button" class="btn btn-secondary">Swap Currencies</button>
                </div>
            
                <!-- Tombol Konversi -->
                <button id="convert-button" class="btn btn-primary">Convert</button>
            
                <!-- Hasil Konversi -->
                <div class="mt-3" id="converted-result"></div>
            </div>
            

            <!-- Calculator Section -->
            <div class="box-container calculator-container">
                <h4 class="text-center">Enhanced Calculator</h4>
                <div class="calculator-body">
                    <div class="calculator-screen">
                        <input type="text" id="calc-screen" class="form-control text-right" disabled>
                    </div>
            
                    <div class="calculator-buttons">
                        <div class="row">
                            <button class="btn btn-light col" onclick="appendNumber(7)">7</button>
                            <button class="btn btn-light col" onclick="appendNumber(8)">8</button>
                            <button class="btn btn-light col" onclick="appendNumber(9)">9</button>
                            <button class="btn btn-warning col" onclick="chooseOperation('divide')">÷</button>
                        </div>
                        <div class="row">
                            <button class="btn btn-light col" onclick="appendNumber(4)">4</button>
                            <button class="btn btn-light col" onclick="appendNumber(5)">5</button>
                            <button class="btn btn-light col" onclick="appendNumber(6)">6</button>
                            <button class="btn btn-warning col" onclick="chooseOperation('multiply')">×</button>
                        </div>
                        <div class="row">
                            <button class="btn btn-light col" onclick="appendNumber(1)">1</button>
                            <button class="btn btn-light col" onclick="appendNumber(2)">2</button>
                            <button class="btn btn-light col" onclick="appendNumber(3)">3</button>
                            <button class="btn btn-warning col" onclick="chooseOperation('subtract')">−</button>
                        </div>
                        <div class="row">
                            <button class="btn btn-light col" onclick="appendNumber(0)">0</button>
                            <button class="btn btn-light col" onclick="clearScreen()">C</button>
                            <button class="btn btn-success col" onclick="calculate()">=</button>
                            <button class="btn btn-warning col" onclick="chooseOperation('add')">+</button>
                        </div>
                        <div class="row">
                            <button class="btn btn-info col" onclick="calculatePercentage()">%</button>
                            <button class="btn btn-info col" onclick="squareNumber()">x²</button>
                            <button class="btn btn-info col" onclick="squareRoot()">√</button>
                            <button class="btn btn-info col" onclick="clearEntry()">CE</button>
                        </div>
                    </div>
                </div>
                <div class="mt-3" id="calc-result"></div>
            </div>

            <!-- Image Upload Section -->
            <div class="box-container upload-container">
                <h4 class="text-center">Upload Your Travel Moments</h4>
                <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Choose an image:</label>
                        <input type="file" name="image" class="form-control" id="image" required>
                    </div>
                    <button type="submit" class="btn btn-upload">Upload Image</button>
                </form>

                <!-- Carousel untuk menampilkan gambar -->
                @if($images->isNotEmpty())
                    <div id="imageCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($images as $index => $image)
                                <div class="carousel-item @if ($index === 0) active @endif">
                                    <!-- Pastikan jalur src menggunakan asset yang benar -->
                                    <img src="{{ asset('storage/' . $image->filename) }}" alt="Gambar">
                                    {{-- <img src="{{ asset('storage/images/' . $image->filename) }}" class="d-block w-100" alt="Uploaded Image {{ $index + 1 }}"> --}}
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <p>No images uploaded yet.</p>
                @endif

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mendapatkan dan menampilkan waktu saat ini
            function updateTimeAndDate() {
                const dateContainer = document.getElementById('current-date');
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                const currentDate = now.toLocaleDateString('id-ID', options); // Format Indonesia
        
                dateContainer.innerHTML = `Waktu Sekarang: ${currentDate}`;
            }
        
            // Fungsi untuk mendapatkan lokasi dan suhu
            function getLocationAndTemperature() {
                const locationContainer = document.getElementById('current-location');
                const temperatureContainer = document.getElementById('current-temperature');
        
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(async function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
        
                        // Mendapatkan lokasi berdasarkan latitude dan longitude
                        const locationResponse = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
                        const locationData = await locationResponse.json();
                        const city = locationData.address.city || locationData.address.village || "Lokasi tidak diketahui";
        
                        locationContainer.innerHTML = `Lokasi: ${city}`;
        
                        // Mendapatkan suhu berdasarkan lokasi
                        const apiKey = '26984e5bdf4c78381f738f1d0402a944'; // Ganti dengan API Key Anda
                        const weatherResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`);
                        const weatherData = await weatherResponse.json();
                        const temperature = weatherData.main.temp;
        
                        temperatureContainer.innerHTML = `Suhu: ${temperature.toFixed(1)}°C`;
                    }, function(error) {
                        locationContainer.innerHTML = "Tidak dapat mendapatkan lokasi";
                        temperatureContainer.innerHTML = "Suhu tidak tersedia";
                    });
                } else {
                    locationContainer.innerHTML = "Geolokasi tidak didukung oleh browser";
                    temperatureContainer.innerHTML = "Suhu tidak tersedia";
                }
            }
        
            // Panggil fungsi untuk memperbarui waktu dan tanggal
            updateTimeAndDate();
            setInterval(updateTimeAndDate, 1000); // Update setiap detik
        
            // Panggil fungsi untuk mendapatkan lokasi dan suhu
            getLocationAndTemperature();
        });
        </script>
        
    <script>

        let currencies = []; // Menyimpan daftar mata uang
        let fromCurrency = 'IDR'; // Mata uang awal (default: Rupiah)
        let toCurrency = ''; // Mata uang tujuan

        // Fungsi untuk memuat daftar mata uang dari API
        async function loadCurrencies() {
            const apiKey = 'e392b4b9e1131b7ff29da55c'; // Kunci API
            const apiUrl = `https://v6.exchangerate-api.com/v6/${apiKey}/codes`;

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                if (data && data.supported_codes) {
                    currencies = data.supported_codes;
                    updateCurrencySelect(''); // Perbarui dropdown
                } else {
                    console.error('Unable to load currencies.');
                }
            } catch (error) {
                console.error('Error fetching currency codes:', error);
            }
        }

        // Fungsi untuk memperbarui dropdown pilihan mata uang
        function updateCurrencySelect(input) {
            const currencySelect = document.getElementById('currency-select');
            currencySelect.innerHTML = '';

            currencies.forEach(code => {
                if (code[0].toLowerCase().includes(input.toLowerCase()) || code[1].toLowerCase().includes(input.toLowerCase())) {
                    const option = document.createElement('option');
                    option.value = code[0];
                    option.textContent = `${code[0]} - ${code[1]}`;
                    currencySelect.appendChild(option);
                }
            });

            currencySelect.style.display = currencySelect.options.length ? 'block' : 'none';
        }

        // Fungsi untuk mengonversi mata uang
        async function convertCurrency() {
            const amount = document.getElementById('amount').value;

            // Validasi input
            if (!amount || amount <= 0) {
                alert('Please enter a valid amount.');
                return;
            }

            const apiKey = 'e392b4b9e1131b7ff29da55c';
            const apiUrl = `https://v6.exchangerate-api.com/v6/${apiKey}/latest/${fromCurrency}`;

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                if (data && data.conversion_rates && data.conversion_rates[toCurrency]) {
                    const rate = data.conversion_rates[toCurrency];
                    const convertedAmount = amount * rate;

                    // Format mata uang
                    const formattedAmountFrom = new Intl.NumberFormat('en-US', { style: 'currency', currency: fromCurrency }).format(amount);
                    const formattedConvertedAmount = new Intl.NumberFormat('en-US', { style: 'currency', currency: toCurrency }).format(convertedAmount);

                    document.getElementById('converted-result').innerText = `${formattedAmountFrom} = ${formattedConvertedAmount}`;
                } else {
                    document.getElementById('converted-result').innerText = 'Unable to retrieve conversion rates.';
                }
            } catch (error) {
                console.error('Error fetching conversion rates:', error);
                document.getElementById('converted-result').innerText = 'An error occurred while fetching conversion rates.';
            }
        }

        // Fungsi untuk menukar mata uang (swap)
        function swapCurrencies() {
            const currencyInput = document.getElementById('currency-input');
            const tempCurrency = fromCurrency;

            fromCurrency = toCurrency ? toCurrency : 'IDR';
            toCurrency = tempCurrency;

            // Perbarui input berdasarkan hasil swap
            currencyInput.value = toCurrency;
            document.getElementById('converted-result').innerText = ''; // Reset hasil konversi
        }

        // Panggil fungsi untuk memuat mata uang saat halaman dimuat
        window.onload = () => {
            loadCurrencies();
            document.getElementById('convert-button').addEventListener('click', convertCurrency);
            document.getElementById('swap-button').addEventListener('click', swapCurrencies);

            // Input untuk mata uang
            document.getElementById('currency-input').addEventListener('input', function() {
                const inputValue = this.value;
                updateCurrencySelect(inputValue);
            });

            // Pilihan mata uang dari dropdown
            document.getElementById('currency-select').addEventListener('change', function() {
                toCurrency = this.value;
                document.getElementById('currency-input').value = toCurrency;
                this.style.display = 'none';
            });

            // Sembunyikan dropdown ketika klik di luar
            document.addEventListener('click', function(event) {
                if (!document.getElementById('currency-input').contains(event.target) && 
                    !document.getElementById('currency-select').contains(event.target)) {
                    document.getElementById('currency-select').style.display = 'none';
                }
            });
        };


        // Simple calculator logic
        let currentOperand = '';
        let previousOperand = '';
        let operation = undefined;

        // Appends a number to the current operand
        function appendNumber(number) {
            currentOperand += number;
            updateDisplay();
        }

        // Sets the operation (add, subtract, multiply, divide)
        function chooseOperation(selectedOperation) {
            if (currentOperand === '') return;
            if (previousOperand !== '') {
                calculate();
            }
            operation = selectedOperation;
            previousOperand = currentOperand;
            currentOperand = '';
        }

        // Calculates based on the selected operation
        function calculate() {
            let result;
            const prev = parseFloat(previousOperand);
            const current = parseFloat(currentOperand);

            if (isNaN(prev) || isNaN(current)) return;

            switch (operation) {
                case 'add':
                    result = prev + current;
                    break;
                case 'subtract':
                    result = prev - current;
                    break;
                case 'multiply':
                    result = prev * current;
                    break;
                case 'divide':
                    result = prev / current;
                    break;
                default:
                    return;
            }

            currentOperand = result;
            operation = undefined;
            previousOperand = '';
            updateDisplay();
        }

        // Clears the entire calculator screen
        function clearScreen() {
            currentOperand = '';
            previousOperand = '';
            operation = undefined;
            updateDisplay();
        }

        // Clears the last entry
        function clearEntry() {
            currentOperand = '';
            updateDisplay();
        }

        // Calculates percentage of the current operand
        function calculatePercentage() {
            if (currentOperand === '') return;
            currentOperand = parseFloat(currentOperand) / 100;
            updateDisplay();
        }

        // Squares the current operand
        function squareNumber() {
            if (currentOperand === '') return;
            currentOperand = Math.pow(parseFloat(currentOperand), 2);
            updateDisplay();
        }

        // Calculates the square root of the current operand
        function squareRoot() {
            if (currentOperand === '') return;
            currentOperand = Math.sqrt(parseFloat(currentOperand));
            updateDisplay();
        }

        // Updates the calculator screen display
        function updateDisplay() {
            document.getElementById('calc-screen').value = currentOperand;
        }


    </script>
</body>
@endsection
