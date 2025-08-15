@extends('layouts.site')

@section('title', $title ?? 'بحث الفنادق - منصة السفر')
@section('description', $description ?? 'ابحث عن فنادق بأفضل الأسعار في جميع أنحاء العالم')

@section('content')
    <!-- Hotel Search Hero -->
    <section class="hotel-search-hero">
        <div class="hero-particles"></div>

        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    <span>{{ session('success') }}</span>
                    <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif
              @if ($errors->any())
                    <div
                        style="background-color: rgb(219, 124, 124); width: 90%; text-align: center; color:white; padding: 2rem; margin-bottom: 1rem; border-radius: 15px">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            <div class="search-header">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="separator">←</span>
                    <span class="current">حجز الفنادق</span>
                </div>
                <h1 class="page-title">
                    <span class="title-icon">🏨</span>
                    احجز فندقك المثالي
                </h1>
                <p class="page-subtitle">اختر من بين آلاف الفنادق المميزة في جميع أنحاء العالم بأفضل الأسعار</p>
            </div>
        </div>
    </section>

    <!-- Hotel Search Form -->
    <section class="hotel-search-section">
        <div class="container">
            <div class="search-form-container">
                <div class="form-header">
                    <h2 class="form-title">تفاصيل الإقامة</h2>
                    <p class="form-subtitle">املأ البيانات أدناه للعثور على أفضل الفنادق المتاحة</p>
                </div>

                <form class="hotel-search-form" id="hotelSearchForm" action="{{ route('hotels.search') }}" method="POST">
                    @csrf
                    <!-- Location Field -->
                    <div class="hotel-location-field">
                        <div class="form-group location-group">
                            <label for="destination" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                                الوجهة
                            </label>
                            <div class="input-wrapper">
                                <input type="text" id="destination" name="destination" class="form-input"
                                    placeholder="اختر مدينة أو فندق" value="{{ old('destination') }}" required>
                                <div class="input-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                            </div>
                            @error('destination')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            <div class="popular-destinations">
                                <span class="popular-label">وجهات شائعة:</span>
                                @foreach (['الرياض', 'جدة', 'دبي', 'القاهرة'] as $city)
                                    <button type="button" class="hotel-location-chip"
                                        onclick="setDestination('destination', '{{ $city }}')">{{ $city }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Date and Guests Grid -->
                    <div class="hotel-datetime-guests-grid">
                        <!-- Check-in and Check-out Dates -->
                        <div class="hotel-datetime-group">
                            <div class="form-group">
                                <label for="checkin" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    تاريخ الوصول
                                </label>
                                <div class="input-wrapper">
                                    <input type="date" id="checkin" name="checkin" class="form-input date-input"
                                        value="{{ old('checkin', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
                                </div>
                                @error('checkin')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="checkout" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    تاريخ المغادرة
                                </label>
                                <div class="input-wrapper">
                                    <input type="date" id="checkout" name="checkout" class="form-input date-input"
                                        value="{{ old('checkout', \Carbon\Carbon::tomorrow()->format('Y-m-d')) }}"
                                        required>
                                </div>
                                @error('checkout')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Guests and Rooms -->
                        <div class="guests-rooms-group">
                            <div class="form-group">
                                <label for="guests" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                    عدد النزلاء
                                </label>
                                <div class="guest-selector">
                                    <button type="button" class="guest-btn" onclick="changeGuests(-1)">-</button>
                                    <input type="number" id="guests" name="guests" class="guest-input"
                                        min="1" max="10" value="{{ old('guests', 2) }}" readonly>
                                    <button type="button" class="guest-btn" onclick="changeGuests(1)">+</button>
                                </div>
                                @error('guests')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms" class="form-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M3 21h18" />
                                        <path d="M5 21V7l8-4v18" />
                                        <path d="M19 21V11l-6-4" />
                                        <path d="M9 9v.01" />
                                        <path d="M9 12v.01" />
                                        <path d="M9 15v.01" />
                                        <path d="M9 18v.01" />
                                    </svg>
                                    عدد الغرف
                                </label>
                                <div class="room-selector">
                                    <button type="button" class="room-btn" onclick="changeRooms(-1)">-</button>
                                    <input type="number" id="rooms" name="rooms" class="room-input"
                                        min="1" max="5" value="{{ old('rooms', 1) }}" readonly>
                                    <button type="button" class="room-btn" onclick="changeRooms(1)">+</button>
                                </div>
                                @error('rooms')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Hotel Preferences -->
                    <div class="hotel-preferences-grid">
                        <!-- Star Rating -->
                        <div class="form-group">
                            <label for="starRating" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polygon
                                        points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                </svg>
                                تصنيف الفندق
                            </label>
                            <div class="input-wrapper">
                                <select id="starRating" name="starRating" class="form-input">
                                    <option value="" {{ old('starRating') == '' ? 'selected' : '' }}>جميع التصنيفات
                                    </option>
                                    <option value="3" {{ old('starRating') == '3' ? 'selected' : '' }}>3 نجوم فأكثر
                                    </option>
                                    <option value="4" {{ old('starRating') == '4' ? 'selected' : '' }}>4 نجوم فأكثر
                                    </option>
                                    <option value="5" {{ old('starRating') == '5' ? 'selected' : '' }}>5 نجوم فقط
                                    </option>
                                </select>
                            </div>
                            @error('starRating')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Price Range -->
                        <div class="form-group">
                            <label for="priceRange" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23" />
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                                نطاق السعر
                            </label>
                            <div class="input-wrapper">
                                <select id="priceRange" name="priceRange" class="form-input">
                                    <option value="" {{ old('priceRange') == '' ? 'selected' : '' }}>جميع الأسعار
                                    </option>
                                    <option value="budget" {{ old('priceRange') == 'budget' ? 'selected' : '' }}>اقتصادي
                                        (أقل من 200 ريال)</option>
                                    <option value="mid" {{ old('priceRange') == 'mid' ? 'selected' : '' }}>متوسط
                                        (200-500 ريال)</option>
                                    <option value="luxury" {{ old('priceRange') == 'luxury' ? 'selected' : '' }}>فاخر
                                        (أكثر من 500 ريال)</option>
                                </select>
                            </div>
                            @error('priceRange')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Hotel Type -->
                        <div class="form-group">
                            <label for="hotelType" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M3 21h18" />
                                    <path d="M5 21V7l8-4v18" />
                                    <path d="M19 21V11l-6-4" />
                                    <path d="M9 9v.01" />
                                    <path d="M9 12v.01" />
                                    <path d="M9 15v.01" />
                                    <path d="M9 18v.01" />
                                </svg>
                                نوع الإقامة
                            </label>
                            <div class="input-wrapper">
                                <select id="hotelType" name="hotelType" class="form-input">
                                    <option value="" {{ old('hotelType') == '' ? 'selected' : '' }}>جميع الأنواع
                                    </option>
                                    <option value="hotel" {{ old('hotelType') == 'hotel' ? 'selected' : '' }}>فندق
                                    </option>
                                    <option value="resort" {{ old('hotelType') == 'resort' ? 'selected' : '' }}>منتجع
                                    </option>
                                    <option value="apartment" {{ old('hotelType') == 'apartment' ? 'selected' : '' }}>شقة
                                        فندقية</option>
                                    <option value="villa" {{ old('hotelType') == 'villa' ? 'selected' : '' }}>فيلا
                                    </option>
                                </select>
                            </div>
                            @error('hotelType')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Amenities -->
                        <div class="form-group">
                            <label for="amenities" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M9 12l2 2 4-4" />
                                    <circle cx="12" cy="12" r="10" />
                                </svg>
                                المرافق المطلوبة
                            </label>
                            <div class="amenities-checkboxes">
                                @foreach (['wifi' => 'واي فاي مجاني', 'pool' => 'مسبح', 'gym' => 'صالة رياضية', 'spa' => 'سبا'] as $value => $label)
                                    <label class="amenity-option">
                                        <input type="checkbox" name="amenities[]" value="{{ $value }}"
                                            {{ in_array($value, old('amenities', [])) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('amenities')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="search-button-container">
                        <button type="submit" class="search-btn">
                            <div class="btn-content">
                                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="M21 21l-4.35-4.35" />
                                </svg>
                                <span class="btn-text">ابحث عن الفنادق</span>
                            </div>
                            <div class="btn-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </section>
@endsection

@section('styles')
    <style>
        .hotel-search-hero {
            background: #f8f9fa;
            padding: 40px 0;
            position: relative;
        }

        .hotel-search-hero {
            padding: 120px 0 60px;
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);

        }

        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/particles.png') no-repeat center;
            opacity: 0.1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .search-header {
            text-align: right;
        }

        .breadcrumb {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .breadcrumb a,
        .breadcrumb .current {
            color: #333;
            text-decoration: none;
        }

        .breadcrumb .separator {
            margin: 0 10px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 2rem;
            font-weight: 700;
        }

        .title-icon {
            font-size: 1.5rem;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: #666;
        }

        .hotel-search-section {
            padding: 40px 0;
        }

        .search-form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: right;
            margin-bottom: 20px;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-subtitle {
            font-size: 1.2rem;
            color: #666;
        }

        .hotel-search-form {
            display: grid;
            gap: 20px;
        }

        .hotel-location-field {
            width: 100%;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .label-icon {
            width: 20px;
            height: 20px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input,
        .date-input,
        .guest-input,
        .room-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .input-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-icon svg {
            width: 20px;
            height: 20px;
        }

        .popular-destinations {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .popular-label {
            font-weight: 700;
            margin-right: 10px;
        }

        .hotel-location-chip {
            padding: 8px 16px;
            background: #e9ecef;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .hotel-location-chip:hover {
            background: #007bff;
            color: #fff;
        }

        .hotel-datetime-guests-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .hotel-datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .guests-rooms-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .guest-selector,
        .room-selector {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .guest-btn,
        .room-btn {
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .guest-btn:hover,
        .room-btn:hover {
            background: #0056b3;
        }

        .guest-input,
        .room-input {
            text-align: center;
            width: 60px;
        }

        .hotel-preferences-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .amenities-checkboxes {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .amenity-option {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkmark {
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .search-button-container {
            text-align: center;
        }

        .search-btn {
            padding: 12px 24px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .search-btn:hover {
            background: #218838;
        }

        .btn-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-icon {
            width: 20px;
            height: 20px;
        }

        .btn-arrow svg {
            width: 20px;
            height: 20px;
        }

        .car-categories-section {
            margin-top: 40px;
        }

        .categories-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: right;
            margin-bottom: 20px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
        }

        .category-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .category-image img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .category-info {
            padding: 10px;
        }

        .category-name {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .category-location {
            font-size: 0.9rem;
            color: #666;
        }

        .category-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .stars {
            font-size: 1rem;
        }

        .rating-text {
            font-size: 0.9rem;
            color: #666;
        }

        .category-price {
            font-size: 1rem;
            font-weight: 700;
        }

        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
        }

          .alert {
            position: relative;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #dc267f, #ff6b35);
            color: #fff;
        }

        .close-alert {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0 10px;
        }

        .close-alert:hover {
            color: #f0f0f0;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function setDestination(inputId, city) {
            document.getElementById(inputId).value = city;
            document.getElementById('hotelSearchForm').submit();
        }

        function quickHotelSearch(hotelName) {
            document.getElementById('destination').value = hotelName;
            document.getElementById('hotelSearchForm').submit();
        }

        function changeGuests(delta) {
            const input = document.getElementById('guests');
            let value = parseInt(input.value);
            value = Math.max(1, Math.min(10, value + delta));
            input.value = value;
        }

        function changeRooms(delta) {
            const input = document.getElementById('rooms');
            let value = parseInt(input.value);
            value = Math.max(1, Math.min(5, value + delta));
            input.value = value;
        }

        // Ensure checkout date is after check-in
        document.getElementById('checkin').addEventListener('change', function() {
            const checkin = new Date(this.value);
            const checkoutInput = document.getElementById('checkout');
            const minCheckout = new Date(checkin);
            minCheckout.setDate(checkin.getDate() + 1);
            checkoutInput.min = minCheckout.toISOString().split('T')[0];
            if (new Date(checkoutInput.value) <= checkin) {
                checkoutInput.value = minCheckout.toISOString().split('T')[0];
            }
        });
    </script>
@endsection



@section('scripts')
    <script>
        // Automatically hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            }
        });
    </script>
@endsection
