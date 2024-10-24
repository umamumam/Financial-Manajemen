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

        <!-- Grid Layout -->
        <div class="grid-container">
            <!-- Currency Conversion Section -->
            <div class="box-container currency-container">
                <h4 class="text-center">Currency Converter</h4>
                <div class="mb-3">
                    <label for="currency" class="form-label">Choose Currency:</label>
                    <input type="text" id="currency-input" class="form-control" placeholder="Type to search currency..." autocomplete="off">
                    <select id="currency-select" class="form-select" size="5" style="display: none;"></select>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (in Rupiah):</label>
                    <input type="number" id="amount" class="form-control" placeholder="Enter amount in IDR" min="0">
                </div>
                <button id="convert-button" class="btn btn-primary">Convert</button>
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

    let currencies = []; // Menyimpan daftar mata uang

    // Fungsi untuk memuat daftar mata uang dari API
    async function loadCurrencies() {
        const apiKey = 'e392b4b9e1131b7ff29da55c'; // Kunci API Anda
        const apiUrl = `https://v6.exchangerate-api.com/v6/${apiKey}/codes`; // API untuk mendapatkan kode mata uang

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            // Cek apakah data tersedia
            if (data && data.supported_codes) {
                currencies = data.supported_codes; // Simpan kode mata uang
                updateCurrencySelect(''); // Memperbarui dropdown dengan semua mata uang
            } else {
                console.error('Unable to load currencies.');
            }
        } catch (error) {
            console.error('Error fetching currency codes:', error);
        }
    }

    // Fungsi untuk memperbarui dropdown berdasarkan input pengguna
    function updateCurrencySelect(input) {
        const currencySelect = document.getElementById('currency-select');
        currencySelect.innerHTML = ''; // Kosongkan dropdown

        currencies.forEach(code => {
            if (code[0].toLowerCase().includes(input.toLowerCase()) || code[1].toLowerCase().includes(input.toLowerCase())) {
                const option = document.createElement('option');
                option.value = code[0]; // Kode mata uang
                option.textContent = `${code[0]} - ${code[1]}`; // Tampilkan kode dan nama mata uang
                currencySelect.appendChild(option);
            }
        });

        // Tampilkan dropdown jika ada opsi
        currencySelect.style.display = currencySelect.options.length ? 'block' : 'none';
    }

    // Fungsi untuk mengonversi mata uang
    async function convertCurrency() {
        const currency = document.getElementById('currency-input').value.trim().toUpperCase();
        const amount = document.getElementById('amount').value;

        // Validasi input
        if (!amount || amount <= 0) {
            alert('Please enter a valid amount in Rupiah.');
            return;
        }

        const apiKey = 'e392b4b9e1131b7ff29da55c'; 
        const apiUrl = `https://v6.exchangerate-api.com/v6/${apiKey}/latest/IDR`; 

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            // Cek apakah data tersedia
            if (data && data.conversion_rates && data.conversion_rates[currency]) {
                const rate = data.conversion_rates[currency]; // Ambil nilai tukar
                const convertedAmount = (amount * rate); // Hitung konversi tanpa fixed

                // Format IDR
                const formattedAmount = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
                // Format mata uang target dengan 2 angka desimal
                const formattedConvertedAmount = new Intl.NumberFormat('en-US', { style: 'currency', currency: currency, minimumFractionDigits: 10, maximumFractionDigits: 10 }).format(convertedAmount);

                // Tampilkan hasil dalam format yang diinginkan
                document.getElementById('converted-result').innerText = `${formattedConvertedAmount} = ${formattedAmount}`;
            } else {
                document.getElementById('converted-result').innerText = 'Unable to retrieve conversion rates.';
            }
        } catch (error) {
            console.error('Error fetching conversion rates:', error);
            document.getElementById('converted-result').innerText = 'An error occurred while fetching conversion rates.';
        }
    }

    // Panggil fungsi untuk memuat mata uang saat halaman dimuat
    window.onload = () => {
        loadCurrencies(); // Memuat daftar mata uang
        document.getElementById('convert-button').addEventListener('click', convertCurrency); // Menambahkan event listener
        
        // Menambahkan event listener untuk input
        document.getElementById('currency-input').addEventListener('input', function() {
            const inputValue = this.value;
            updateCurrencySelect(inputValue);
        });

        // Menambahkan event listener untuk memilih mata uang dari dropdown
        document.getElementById('currency-select').addEventListener('change', function() {
            document.getElementById('currency-input').value = this.value; // Set nilai input dengan yang dipilih
            this.style.display = 'none'; // Sembunyikan dropdown
        });

        // Menyembunyikan dropdown ketika mengklik di luar
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
