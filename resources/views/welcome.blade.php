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
            transition: background-color 0.3s, transform 0.3s;
        }

        .cta-btn:hover {
            background-color: #48965b;
            transform: scale(1.05);
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
            animation: fadeInUp 1.2s ease-out;
        }

        .hero-title {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-out;
        }

        .hero-subtitle {
            font-size: 24px;
            margin-bottom: 40px;
            opacity: 0;
            animation: fadeSlideIn 2s ease-out forwards;
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

        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Features Section */
        .features-section {
            padding: 80px 20px;
            text-align: center;
        }

        .section-title {
            font-size: 36px;
            margin-bottom: 40px;
            animation: fadeInUp 1.5s ease-out;
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
            transition: transform 0.3s, box-shadow 0.3s;
            animation: fadeInRight 1s ease-out;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeInLeft 1s ease-out;
        }

        .about-content {
            max-width: 500px;
            padding: 20px;
        }

        .about-content h2 {
            font-size: 36px;
            color: #5DB075;
            margin-bottom: 20px;
        }

        .about-content p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        .about-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .about-section img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Contact Section */
        .contact-section {
            text-align: center;
            padding: 80px 20px;
            background-color: #f9f9f9;
            animation: fadeInUp 1.5s ease-out;
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
            transition: border-color 0.3s;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #5DB075;
        }

        .contact-form button {
            margin-top: 20px;
            animation: fadeInUp 2s ease-out;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .features-container {
                flex-direction: column;
            }

            .feature-card {
                flex-basis: 100%;
                animation: fadeInUp 1s ease-out;
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
            <h2>About Our Platform</h2>
            <p>We provide cutting-edge tools and expert insights to help you manage your finances and achieve your financial goals. Our platform offers budgeting tools, savings goal tracking, and personalized investment advice to help you grow your wealth efficiently.</p>
        </div>
        <div class="about-image">
            <img src="https://img.freepik.com/premium-vector/diverse-group-celebrates-success-business-competition-showcasing-trophies-while-standing-podiums-urban-environment_538213-123486.jpg" alt="Financial Growth">
        </div>
    </section>

    <section id="contact" class="contact-section">
        <h2>Contact Us</h2>
        <form class="contact-form" action="#" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="cta-btn">Send Message</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Finance Company. All rights reserved.</p>
    </footer>
</body>

</html>
