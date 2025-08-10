<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'منصة السفر - احجز رحلتك المثالية')</title>
    <meta name="description" content="@yield('description', 'منصة شاملة لحجز الطيران والفنادق وتأجير السيارات بأفضل الأسعار')">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-content">
                <!-- Logo -->
                <div class="logo">
                    <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                    </svg>
                    <span class="logo-text">منصة السفر</span>
                </div>

                <!-- Desktop Menu -->
                <div class="nav-menu">
                    <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                    <a href="{{ route('home') }}#booking" class="nav-link">الحجوزات</a>
                    <a href="{{ route('home') }}#services" class="nav-link">خدماتنا</a>
                    <a href="#about" class="nav-link">من نحن</a>
                    <a href="#contact" class="nav-link">اتصل بنا</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="login-btn">لوحة التحكم</a>
                        @else
                    <a href="{{ route('login') }}" class="login-btn">تسجيل الدخول</a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="mobile-menu-toggle">
                    <input type="checkbox" id="menu-toggle">
                    <label for="menu-toggle" class="menu-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>

                    <!-- Mobile Menu -->
                    <div class="mobile-menu">
                        <a href="{{ route('home') }}" class="mobile-nav-link">الرئيسية</a>
                        <a href="{{ route('home') }}#booking" class="mobile-nav-link">الحجوزات</a>
                        <a href="{{ route('home') }}#services" class="mobile-nav-link">خدماتنا</a>
                        <a href="#about" class="mobile-nav-link">من نحن</a>
                        <a href="#contact" class="mobile-nav-link">اتصل بنا</a>
                        @auth
                        <a href="{{ route('dashboard') }}" class="mobile-login-btn">لوحة التحكم</a>
                        @else
                        <a href="{{ route('login') }}" class="mobile-login-btn">تسجيل الدخول</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <svg class="footer-logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                        </svg>
                        <span class="footer-logo-text">منصة السفر</span>
                    </div>
                    <p class="footer-desc">شريكك المثالي في رحلات السفر والسياحة حول العالم</p>
                </div>

                <div class="footer-section">
                    <h3 class="footer-title">خدماتنا</h3>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">حجز الطيران</a></li>
                        <li><a href="#" class="footer-link">حجز الفنادق</a></li>
                        <li><a href="#" class="footer-link">تأجير السيارات</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3 class="footer-title">روابط مفيدة</h3>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">من نحن</a></li>
                        <li><a href="#" class="footer-link">اتصل بنا</a></li>
                        <li><a href="#" class="footer-link">الشروط والأحكام</a></li>
                        <li><a href="#" class="footer-link">سياسة الخصوصية</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3 class="footer-title">تابعنا</h3>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} منصة السفر. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
