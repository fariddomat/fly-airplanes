<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'منصة السفر') }} - @yield('title', 'تسجيل الدخول')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline Styles -->
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            direction: rtl;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            direction: rtl;
            overflow-x: hidden;

            display: flex;
            flex-direction: column;
        }

        .main-h {
            background-image: linear-gradient(rgba(0, 0, 60, 0.6), rgba(0, 0, 60, 0.6)), url("{{ asset('images/phtoto.png') }}");
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(220, 38, 127, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 36px;
            color: #dc267f;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #dc267f, #ff6b35);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-link {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #dc267f;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            right: 0;
            background: linear-gradient(135deg, #dc267f, #ff6b35);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Guest Container */
        .guest-container {
            margin: 100px auto;
            padding: 20px;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Guest Card */
        .guest-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 12px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .guest-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .guest-card label {
            font-weight: 500;
            color: #2c3e50;
            text-align: right;
            margin-bottom: 5px;
            display: block;
        }

        .guest-card input {
            padding: 12px;
            border: 1px solid rgba(220, 38, 127, 0.3);
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .guest-card input:focus {
            outline: none;
            border-color: #dc267f;
            box-shadow: 0 0 8px rgba(220, 38, 127, 0.3);
        }

        .guest-card button {
            background: linear-gradient(135deg, #dc267f, #ff6b35);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 127, 0.3);
        }

        .guest-card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 127, 0.4);
        }

        .guest-card a {
            color: #dc267f;
            text-decoration: none;
            font-weight: 500;
        }

        .guest-card a:hover {
            color: #ff6b35;
            text-decoration: underline;
        }

        /* Checkbox */
        .guest-card input[type="checkbox"] {
            accent-color: #dc267f;
            margin-left: 0.5rem;
        }

        .guest-card .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 14px;
            color: #2c3e50;
        }

        /* Error Messages */
        .guest-card .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
            text-align: right;
        }

        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(220, 38, 127, 0.1);
            color: #2c3e50;
            padding: 20px;
            text-align: center;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }

        .footer a {
            color: #dc267f;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }

        .footer a:hover {
            color: #ff6b35;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                gap: 10px;
                height: auto;
                padding: 15px 0;
            }

            .nav-menu {
                flex-direction: column;
                gap: 15px;
            }

            .guest-card {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body class="antialiased">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-content">
                <a href="{{ route('home') }}" class="logo" wire:navigate>
                    <span class="logo-icon">✈️</span>
                    <span class="logo-text">منصة السفر</span>
                </a>
                <div class="nav-menu">
                    <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                    <a href="{{ route('flights.search') }}" class="nav-link">حجز رحلة جوية</a>
                    <a href="{{ route('cars.search') }}" class="nav-link">حجز سيارة</a>
                    <a href="{{ route('hotels.search') }}" class="nav-link">حجز فندق</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Guest Content -->
    <div class="main-h">
        <div class="guest-container ">
            <div class="guest-card">

                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>© {{ now()->year }} منصة السفر. جميع الحقوق محفوظة.</p>
        <p>
            <a href="#">سياسة الخصوصية</a> |
            <a href="#">شروط الخدمة</a> |
            <a href="#">تواصل معنا</a>
        </p>
    </footer>

    @livewireScripts
</body>

</html>
