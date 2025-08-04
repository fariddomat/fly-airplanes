@extends('layouts.site')

@section('content')
    <!-- First Hero Section - Simple with Flight Only -->
    <section id="home" class="main-hero">
        <div class="hero-particles"></div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="main-title">
                    <span class="title-line">اكتشف العالم</span>
                    <span class="title-line gradient-text">مع منصة السفر</span>
                </h1>
                <p class="main-slogan">رحلتك تبدأ من هنا - احجز بثقة وسافر بأمان</p>

                <div class="flight-cta">
                    <a href="{{ route('flights.search') }}" class="primary-flight-btn">
                        <div class="btn-content">
                            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                            </svg>
                            <div class="btn-text">
                                <span class="btn-title">احجز رحلتك الآن</span>
                                <span class="btn-subtitle">أفضل الأسعار مضمونة</span>
                            </div>
                        </div>
                        <div class="btn-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="floating-elements">
            <div class="floating-card card-1">
                <div class="card-icon">✈️</div>
                <div class="card-text">500+ شركة طيران</div>
            </div>
            <div class="floating-card card-2">
                <div class="card-icon">🌍</div>
                <div class="card-text">200+ وجهة</div>
            </div>
            <div class="floating-card card-3">
                <div class="card-icon">⭐</div>
                <div class="card-text">تقييم 4.9/5</div>
            </div>
        </div>
    </section>

    <!-- Second Section - Full Booking Options -->
    <section id="booking" class="booking-hero">
        <div class="section-background">
            <div class="bg-pattern"></div>
        </div>

        <div class="container">
            <div class="booking-content">
                <div class="section-header">
                    <h2 class="section-title">اختر خدمتك المفضلة</h2>
                    <p class="section-subtitle">نقدم لك مجموعة شاملة من خدمات السفر بأفضل الأسعار والجودة</p>
                </div>

                <div class="booking-grid">
                    <!-- Flight Booking Card -->
                    <div class="booking-card flight-card">
                        <div class="card-header">
                            <div class="card-icon-wrapper flight-icon">
                                <svg class="card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                                </svg>
                            </div>
                            <div class="card-badge">الأكثر طلباً</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">حجز الطيران</h3>
                            <p class="card-description">احجز تذاكر الطيران بأفضل الأسعار مع أكثر من 500 شركة طيران عالمية</p>
                            <div class="card-features">
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>أسعار مضمونة</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>إلغاء مجاني</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>دعم 24/7</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('flights.search') }}" class="card-btn flight-btn">
                                <span>احجز الآن</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Car Rental Card -->
                    <div class="booking-card car-card">
                        <div class="card-header">
                            <div class="card-icon-wrapper car-icon">
                                <svg class="card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9L18.4 10c-.4-.8-1.2-1.3-2.1-1.3H7.7c-.9 0-1.7.5-2.1 1.3l-2.1 1.1C2.7 11.3 2 12.1 2 13v3c0 .6.4 1 1 1h2"/>
                                    <circle cx="7" cy="17" r="2"/>
                                    <path d="M9 17h6"/>
                                    <circle cx="17" cy="17" r="2"/>
                                </svg>
                            </div>
                            <div class="card-badge car-badge">مرونة كاملة</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">تأجير السيارات</h3>
                            <p class="card-description">استأجر سيارة مناسبة لرحلتك من مجموعة واسعة من السيارات الحديثة</p>
                            <div class="card-features">
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>سيارات حديثة</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>تأمين شامل</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>استلام فوري</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('cars.search') }}" class="card-btn car-btn">
                                <span>احجز الآن</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Hotel Booking Card -->
                    <div class="booking-card hotel-card">
                        <div class="card-header">
                            <div class="card-icon-wrapper hotel-icon">
                                <svg class="card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21h18"/>
                                    <path d="M5 21V7l8-4v18"/>
                                    <path d="M19 21V11l-6-4"/>
                                    <path d="M9 9v.01"/>
                                    <path d="M9 12v.01"/>
                                    <path d="M9 15v.01"/>
                                    <path d="M9 18v.01"/>
                                </svg>
                            </div>
                            <div class="card-badge hotel-badge">إقامة مميزة</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">حجز الفنادق</h3>
                            <p class="card-description">اختر من بين آلاف الفنادق المميزة في جميع أنحاء العالم بأسعار تنافسية</p>
                            <div class="card-features">
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>فنادق 5 نجوم</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>إفطار مجاني</span>
                                </div>
                                <div class="feature">
                                    <span class="feature-icon">✓</span>
                                    <span>واي فاي مجاني</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('hotels.search') }}" class="card-btn hotel-btn">
                                <span>احجز الآن</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدماتنا المتميزة</h2>
                <p class="section-subtitle">نقدم لك مجموعة شاملة من خدمات السفر والسياحة لضمان رحلة مثالية ومريحة</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon emirates">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                        </svg>
                    </div>
                    <h3 class="service-title">حجز الطيران</h3>
                    <p class="service-desc">احجز تذاكر الطيران بأفضل الأسعار مع أكثر من 500 شركة طيران حول العالم</p>
                </div>

                <div class="service-card">
                    <div class="service-icon qatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 21h18"/>
                            <path d="M5 21V7l8-4v18"/>
                            <path d="M19 21V11l-6-4"/>
                            <path d="M9 9v.01"/>
                            <path d="M9 12v.01"/>
                            <path d="M9 15v.01"/>
                            <path d="M9 18v.01"/>
                        </svg>
                    </div>
                    <h3 class="service-title">حجز الفنادق</h3>
                    <p class="service-desc">اختر من بين آلاف الفنادق المميزة في جميع أنحاء العالم بأسعار تنافسية</p>
                </div>

                <div class="service-card">
                    <div class="service-icon turkish">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9L18.4 10c-.4-.8-1.2-1.3-2.1-1.3H7.7c-.9 0-1.7.5-2.1 1.3l-2.1 1.1C2.7 11.3 2 12.1 2 13v3c0 .6.4 1 1 1h2"/>
                            <circle cx="7" cy="17" r="2"/>
                            <path d="M9 17h6"/>
                            <circle cx="17" cy="17" r="2"/>
                        </svg>
                    </div>
                    <h3 class="service-title">تأجير السيارات</h3>
                    <p class="service-desc">استأجر سيارة مناسبة لرحلتك من مجموعة واسعة من السيارات الحديثة</p>
                </div>

                <div class="service-card">
                    <div class="service-icon etihad">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                    </div>
                    <h3 class="service-title">عروض مميزة</h3>
                    <p class="service-desc">استفد من عروضنا الحصرية والخصومات الخاصة على جميع خدمات السفر</p>
                </div>

                <div class="service-card">
                    <div class="service-icon lufthansa">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="service-title">دعم العملاء</h3>
                    <p class="service-desc">فريق دعم متاح على مدار الساعة لمساعدتك في جميع استفساراتك</p>
                </div>

                <div class="service-card">
                    <div class="service-icon british">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <h3 class="service-title">دليل السفر</h3>
                    <p class="service-desc">احصل على معلومات شاملة عن الوجهات السياحية ونصائح السفر المفيدة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2 class="section-title">من نحن</h2>
                    <p class="about-paragraph">
                        منصة السفر هي شركة رائدة في مجال السياحة والسفر، نقدم خدمات متكاملة لجعل رحلتك تجربة لا تُنسى. مع خبرة
                        تزيد عن 10 سنوات في هذا المجال، نفخر بخدمة أكثر من مليون عميل حول العالم.
                    </p>
                    <p class="about-paragraph">
                        نسعى دائماً لتقديم أفضل الخدمات بأسعار تنافسية، مع ضمان الجودة والراحة في كل خطوة من رحلتك. فريقنا
                        المتخصص متاح على مدار الساعة لضمان حصولك على تجربة سفر مثالية.
                    </p>

                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">1M+</div>
                            <div class="stat-label">عميل سعيد</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">شركة طيران</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">دولة</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">دعم العملاء</div>
                        </div>
                    </div>
                </div>

                <div class="about-image">
                    <img src="{{ asset('images/phtoto.png') }}" alt="فريق العمل" class="team-image">
                    <div class="experience-badge">
                        <div class="experience-number">10+</div>
                        <div class="experience-text">سنوات خبرة</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title white">تواصل معنا</h2>
                <p class="section-subtitle light">نحن هنا لمساعدتك في تخطيط رحلتك المثالية. تواصل معنا الآن</p>
            </div>

            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <h3 class="contact-title">اتصل بنا</h3>
                    <p class="contact-info">+966 11 123 4567</p>
                    <p class="contact-info">+966 50 123 4567</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <h3 class="contact-title">راسلنا</h3>
                    <p class="contact-info">info@travel-platform.com</p>
                    <p class="contact-info">support@travel-platform.com</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <h3 class="contact-title">زورنا</h3>
                    <p class="contact-info">الرياض، المملكة العربية السعودية</p>
                    <p class="contact-info">شارع الملك فهد، الحي التجاري</p>
                </div>
            </div>
        </div>
    </section>
@endsection
