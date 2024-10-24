<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Landing Page</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #d2cfcf;
            color: #006d1d;
            scroll-behavior: smooth;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .cta-btn {
            padding: 12px 24px;
            background-color: #5DB075;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .cta-btn:hover {
            background-color: #48965b;
        }

        /* Header Section */
        .header {
            position: relative;
            height: 100vh;
            background: url('{{ asset('hero-bg-light.webp') }}') center/cover no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* White Transparent Layer */
        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1;
        }

        .hero {
            z-index: 2;
            color: rgb(9, 44, 200);
        }

        .hero-title {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-out;
        }

        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(20px); /* Geser sedikit ke bawah */
            }
            100% {
                opacity: 1;
                transform: translateY(0); /* Kembali ke posisi semula */
            }
        }

        .hero-subtitle {
            font-size: 24px;
            margin-bottom: 40px;
            opacity: 0; /* Awalnya tidak terlihat */
            animation: fadeSlideIn 2s ease-out forwards; /* Animasi muncul dan geser ke atas */
        }


        /* Features Section */
        .features-section {
            padding: 80px 20px;
            text-align: center;
        }

        .section-title {
            font-size: 36px;
            margin-bottom: 40px;
        }

        .features-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .feature-card {
            background-color: white;
            padding: 30px;
            margin: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            flex-basis: 30%;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        /* About Section */
        .about-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 80px 20px;
            background-color: #fff; /* Latar belakang putih */
            border-radius: 8px; /* Menambahkan sudut melengkung */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
        }

        .about-content {
            max-width: 500px;
            padding: 20px; /* Memberikan sedikit padding untuk estetika */
        }

        .about-content h2 {
            font-size: 36px; /* Ukuran font lebih besar untuk judul */
            color: #5DB075; /* Warna hijau yang menarik */
            margin-bottom: 20px;
        }

        .about-content p {
            font-size: 18px; /* Ukuran font yang nyaman dibaca */
            line-height: 1.6; /* Jarak antar baris untuk keterbacaan yang lebih baik */
            color: #555; /* Warna teks yang lebih lembut */
        }

        .about-image {
            flex: 1; /* Mengizinkan gambar untuk mengambil ruang yang sesuai */
            display: flex;
            justify-content: center; /* Memusatkan gambar */
        }

        .about-section img {
            max-width: 100%; /* Memastikan gambar tidak melampaui batas kontainer */
            height: auto; /* Mempertahankan proporsi gambar */
            border-radius: 8px; /* Menambahkan sudut melengkung pada gambar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan lembut di gambar */
        }

        /* Contact Section */
        .contact-section {
            text-align: center;
            padding: 80px 20px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .contact-form button {
            margin-top: 20px;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .features-container {
                flex-direction: column;
            }

            .feature-card {
                flex-basis: 100%;
            }

            .about-section {
                flex-direction: column;
                text-align: center;
            }

            .about-section img {
                margin: 40px 0;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="hero">
            <h1 class="hero-title">
                <span style="color: red;">Smart Financial</span> Management
            </h1>
            <p class="hero-subtitle">Start Saving, Start Growing</p>
            <button class="cta-btn" onclick="window.location.href='/pendapatan'">Get Started</button>
        </div>
    </header>

    <section id="features" class="features-section">
        <h2 class="section-title">Our Features</h2>
        <div class="features-container">
            <div class="feature-card">
                <img src="https://img.freepik.com/fotos-premium/vector-planificacion-presupuestaria-espacio-trabajo-financiero-moderno-graficos-documentos_1198884-37267.jpg" alt="Budgeting">
                <h3>Budgeting Tools</h3>
                <p>Manage your finances effortlessly with intuitive budgeting features.</p>
            </div>
            <div class="feature-card">
                <img src="https://blog-asset.jakmall.com/2023/03/12i1yFMME7MAAAAAElFTkSuQmCC.png" alt="Savings">
                <h3>Savings Goals</h3>
                <p>Set and track your savings goals easily to achieve financial freedom.</p>
            </div>
            <div class="feature-card">
                <img src="https://blog-asset.jakmall.com/2023/03/download--5-.png" alt="Investment">
                <h3>Investment Insights</h3>
                <p>Get personalized investment recommendations and grow your wealth.</p>
            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="about-content">
            <h2>About Us</h2>
            <p>SaveSmart is your trusted partner in smart financial planning, helping you save more and spend wisely. Our team of experts is dedicated to providing you with the tools and knowledge to manage your finances effectively.</p>
        </div>
        <div class="about-image">
            <img src="https://img.freepik.com/premium-vector/diverse-group-celebrates-success-business-competition-showcasing-trophies-while-standing-podiums-urban-environment_538213-123486.jpg" alt="Financial Growth">
        </div>
    </section>
  
    <section id="contact" class="contact-section">
        <h2 class="section-title">Contact Us</h2>
        <form class="contact-form" id="contactForm">
            <input type="text" id="name" placeholder="Your Name" required>
            <input type="email" id="email" placeholder="Your Email" >
            <textarea id="message" placeholder="Your Message" required></textarea>
            <button type="submit" class="cta-btn">Send Message</button>
        </form>
    </section>
    
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form agar tidak di-submit secara default
    
            // Ambil nilai dari input form
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var message = document.getElementById('message').value;
    
            // Buat pesan WhatsApp dengan inputan form
            var whatsappMessage = "Halo, aku " + name + ".  " + message;
    
            // Buat URL WhatsApp dengan nomor tujuan dan pesan
            var whatsappUrl = "https://wa.me/6285799352991?text=" + encodeURIComponent(whatsappMessage);
    
            // Redirect ke WhatsApp
            window.open(whatsappUrl, '_blank');
        });
    </script>

    <footer>
        <p>&copy; 2024 SaveSmart. All Rights Reserved.</p>
    </footer>
</body>

</html>
