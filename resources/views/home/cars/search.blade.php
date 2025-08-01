@extends('layouts.site')

@section('title', $title ?? 'بحث تأجير السيارات - منصة السفر')
@section('description', $description ?? 'ابحث عن سيارات للإيجار بأفضل الأسعار')

@section('content')
    <!-- Car Search Hero -->
    <section class="car-search-hero">
        <div class="hero-particles"></div>
        <div class="container">
            <div class="search-header">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="separator">←</span>
                    <span class="current">تأجير السيارات</span>
                </div>
                <h1 class="page-title">
                    <span class="title-icon">🚗</span>
                    احجز سيارتك المثالية
                </h1>
                <p class="page-subtitle">اختر من بين مجموعة واسعة من السيارات الحديثة بأفضل الأسعار</p>
            </div>
        </div>
    </section>

    <!-- Car Search Form -->
    <section class="car-search-section">
        <div class="container">
            <div class="search-form-container">
                <div class="form-header">
                    <h2 class="form-title">تفاصيل الحجز</h2>
                    <p class="form-subtitle">املأ البيانات أدناه للعثور على أفضل السيارات المتاحة</p>
                </div>

                <form class="car-search-form" id="carSearchForm" action="{{ route('cars.search') }}" method="POST">
                    @csrf
                    <!-- Rental Type Selection -->
                    <div class="rental-type-section">
                        <div class="rental-type-options">
                            <label class="rental-type-option">
                                <input type="radio" name="rentalType" value="same-location" {{ old('rentalType', 'same-location') == 'same-location' ? 'checked' : '' }}>
                                <span class="option-text">نفس موقع الاستلام والتسليم</span>
                            </label>
                            <label class="rental-type-option">
                                <input type="radio" name="rentalType" value="different-location" {{ old('rentalType') == 'different-location' ? 'checked' : '' }}>
                                <span class="option-text">مواقع مختلفة للاستلام والتسليم</span>
                            </label>
                        </div>
                    </div>

                    <!-- Location Fields -->
                    <div class="location-fields-grid" id="locationFields">
                        <!-- Pickup Location -->
                        <div class="form-group location-group">
                            <label for="pickupLocation" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                موقع الاستلام
                            </label>
                            <div class="input-wrapper">
                                <select id="pickupLocation" name="pickupLocation" class="form-input" required>
                                    <option value="">اختر مدينة أو مطار</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->city }}" {{ old('pickupLocation') == $airport->city ? 'selected' : '' }}>{{ $airport->name }} - {{ $airport->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="popular-locations">
                                <span class="popular-label">مواقع شائعة:</span>
                                @foreach($airports->take(3) as $airport)
                                    <button type="button" class="location-chip" onclick="setLocation('pickupLocation', '{{ $airport->city }}')">{{ $airport->city }}</button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dropoff Location -->
                        <div class="form-group location-group" id="dropoffLocationGroup" style="display: none;">
                            <label for="dropoffLocation" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 3l18 18M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                موقع التسليم
                            </label>
                            <div class="input-wrapper">
                                <select id="dropoffLocation" name="dropoffLocation" class="form-input">
                                    <option value="">اختر مدينة أو مطار</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->city }}" {{ old('dropoffLocation') == $airport->city ? 'selected' : '' }}>{{ $airport->name }} - {{ $airport->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="popular-locations">
                                <span class="popular-label">مواقع شائعة:</span>
                                @foreach($airports->take(3) as $airport)
                                    <button type="button" class="location-chip" onclick="setLocation('dropoffLocation', '{{ $airport->city }}')">{{ $airport->city }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Date and Time Selection -->
                    <div class="datetime-grid">
                        <div class="datetime-group">
                            <div class="form-group">
                                <label for="pickupDate" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    تاريخ الاستلام
                                </label>
                                <div class="input-wrapper">
                                    <input type="date" id="pickupDate" name="pickupDate" class="form-input date-input" value="{{ old('pickupDate') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pickupTime" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12,6 12,12 16,14"/>
                                    </svg>
                                    وقت الاستلام
                                </label>
                                <div class="input-wrapper">
                                    <select id="pickupTime" name="pickupTime" class="form-input" required>
                                        @foreach(['09:00' => '09:00 صباحاً', '10:00' => '10:00 صباحاً', '11:00' => '11:00 صباحاً', '12:00' => '12:00 ظهراً', '13:00' => '01:00 ظهراً', '14:00' => '02:00 ظهراً', '15:00' => '03:00 عصراً', '16:00' => '04:00 عصراً', '17:00' => '05:00 عصراً', '18:00' => '06:00 مساءً', '19:00' => '07:00 مساءً', '20:00' => '08:00 مساءً'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('pickupTime') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="datetime-group">
                            <div class="form-group">
                                <label for="dropoffDate" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    تاريخ التسليم
                                </label>
                                <div class="input-wrapper">
                                    <input type="date" id="dropoffDate" name="dropoffDate" class="form-input date-input" value="{{ old('dropoffDate') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dropoffTime" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12,6 12,12 16,14"/>
                                    </svg>
                                    وقت التسليم
                                </label>
                                <div class="input-wrapper">
                                    <select id="dropoffTime" name="dropoffTime" class="form-input" required>
                                        @foreach(['09:00' => '09:00 صباحاً', '10:00' => '10:00 صباحاً', '11:00' => '11:00 صباحاً', '12:00' => '12:00 ظهراً', '13:00' => '01:00 ظهراً', '14:00' => '02:00 ظهراً', '15:00' => '03:00 عصراً', '16:00' => '04:00 عصراً', '17:00' => '05:00 عصراً', '18:00' => '06:00 مساءً', '19:00' => '07:00 مساءً', '20:00' => '08:00 مساءً'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('dropoffTime') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Car Preferences -->
                    <div class="preferences-grid">
                        <div class="form-group">
                            <label for="carType" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9L18.4 10c-.4-.8-1.2-1.3-2.1-1.3H7.7c-.9 0-1.7.5-2.1 1.3l-2.1 1.1C2.7 11.3 2 12.1 2 13v3c0 .6.4 1 1 1h2"/>
                                    <circle cx="7" cy="17" r="2"/>
                                    <path d="M9 17h6"/>
                                    <circle cx="17" cy="17" r="2"/>
                                </svg>
                                نوع السيارة
                            </label>
                            <div class="input-wrapper">
                                <select id="carType" name="carType" class="form-input">
                                    <option value="">جميع الأنواع</option>
                                    @foreach(['economy' => 'اقتصادية', 'compact' => 'مدمجة', 'sedan' => 'سيدان', 'suv' => 'دفع رباعي (SUV)', 'luxury' => 'فاخرة', 'van' => 'فان عائلي', 'convertible' => 'مكشوفة'] as $value => $label)
                                        <option value="{{ $value }}" {{ old('carType') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transmission" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M12 1v6m0 6v6"/>
                                    <path d="M21 12h-6m-6 0H3"/>
                                </svg>
                                ناقل الحركة
                            </label>
                            <div class="input-wrapper">
                                <select id="transmission" name="transmission" class="form-input">
                                    <option value="">جميع الأنواع</option>
                                    <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>أوتوماتيك</option>
                                    <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>يدوي</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fuelType" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 12h18l-3-3m0 6l3-3"/>
                                    <path d="M19 21V9a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v12"/>
                                </svg>
                                نوع الوقود
                            </label>
                            <div class="input-wrapper">
                                <select id="fuelType" name="fuelType" class="form-input">
                                    <option value="">جميع الأنواع</option>
                                    <option value="petrol" {{ old('fuelType') == 'petrol' ? 'selected' : '' }}>بنزين</option>
                                    <option value="diesel" {{ old('fuelType') == 'diesel' ? 'selected' : '' }}>ديزل</option>
                                    <option value="hybrid" {{ old('fuelType') == 'hybrid' ? 'selected' : '' }}>هجين</option>
                                    <option value="electric" {{ old('fuelType') == 'electric' ? 'selected' : '' }}>كهربائي</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="driverAge" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                عمر السائق
                            </label>
                            <div class="input-wrapper">
                                <select id="driverAge" name="driverAge" class="form-input" required>
                                    <option value="">اختر العمر</option>
                                    <option value="21-24" {{ old('driverAge') == '21-24' ? 'selected' : '' }}>21-24 سنة</option>
                                    <option value="25-29" {{ old('driverAge') == '25-29' ? 'selected' : '' }}>25-29 سنة</option>
                                    <option value="30-64" {{ old('driverAge') == '30-64' ? 'selected' : '' }}>30-64 سنة</option>
                                    <option value="65+" {{ old('driverAge') == '65+' ? 'selected' : '' }}>65+ سنة</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Options -->
                    <div class="additional-options">
                        <h3 class="options-title">خيارات إضافية</h3>
                        <div class="options-grid">
                            <label class="option-checkbox">
                                <input type="checkbox" name="gps" value="1" {{ old('gps') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div class="option-info">
                                    <span class="option-name">نظام GPS</span>
                                    <span class="option-price">+25 ريال/يوم</span>
                                </div>
                            </label>
                            <label class="option-checkbox">
                                <input type="checkbox" name="childSeat" value="1" {{ old('childSeat') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div class="option-info">
                                    <span class="option-name">مقعد أطفال</span>
                                    <span class="option-price">+15 ريال/يوم</span>
                                </div>
                            </label>
                            <label class="option-checkbox">
                                <input type="checkbox" name="additionalDriver" value="1" {{ old('additionalDriver') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div class="option-info">
                                    <span class="option-name">سائق إضافي</span>
                                    <span class="option-price">+30 ريال/يوم</span>
                                </div>
                            </label>
                            <label class="option-checkbox">
                                <input type="checkbox" name="insurance" value="1" {{ old('insurance') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div class="option-info">
                                    <span class="option-name">تأمين شامل</span>
                                    <span class="option-price">+50 ريال/يوم</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="search-button-container">
                        <button type="submit" class="search-btn">
                            <div class="btn-content">
                                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="M21 21l-4.35-4.35"/>
                                </svg>
                                <span class="btn-text">ابحث عن السيارات</span>
                            </div>
                            <div class="btn-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        function setLocation(fieldId, location) {
            document.getElementById(fieldId).value = location;
        }

        function selectCarType(type) {
            document.getElementById('carType').value = type;
        }

        function quickSearch(location) {
            document.getElementById('pickupLocation').value = location;
            document.getElementById('carSearchForm').submit();
        }

        document.querySelectorAll('input[name="rentalType"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('dropoffLocationGroup').style.display = this.value === 'different-location' ? 'block' : 'none';
            });
        });
    </script>
@endsection
