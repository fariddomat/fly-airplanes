@extends('layouts.site')

@section('title', $title ?? 'بحث الطيران - منصة السفر')
@section('description', $description ?? 'ابحث عن رحلات الطيران بأفضل الأسعار مع منصة السفر')

@section('content')
    <!-- Flight Search Hero -->
    <section class="flight-search-hero">
        <div class="hero-particles"></div>
        <div class="container">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    <span>{{ session('success') }}</span>
                    <button class="close-alert" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif
            <div class="search-header">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="separator">←</span>
                    <span class="current">بحث الرحلات</span>
                </div>
                <h1 class="page-title">
                    <span class="title-icon">✈️</span>
                    ابحث عن رحلتك المثالية
                </h1>
                <p class="page-subtitle">اكتشف أفضل العروض على رحلات الطيران حول العالم</p>
            </div>
        </div>
    </section>

    <!-- Flight Search Form -->
    <section class="flight-search-section">
        <div class="container">
            <div class="search-form-container">
                <div class="form-header">
                    <h2 class="form-title">تفاصيل رحلتك</h2>
                    <p class="form-subtitle">املأ البيانات أدناه للعثور على أفضل الرحلات</p>
                </div>

                <form class="flight-search-form" id="flightSearchForm" action="{{ route('flights.search') }}"
                    method="POST">
                    @csrf
                    <!-- Trip Type Selection -->
                    <div class="trip-type-section">
                        <div class="trip-type-options">
                            <label class="trip-type-option">
                                <input type="radio" name="tripType" value="roundtrip"
                                    {{ old('tripType', 'roundtrip') == 'roundtrip' ? 'checked' : '' }}
                                    onchange="toggleReturnDate()">
                                <span class="option-text">ذهاب وعودة</span>
                            </label>
                            <label class="trip-type-option">
                                <input type="radio" name="tripType" value="oneway"
                                    {{ old('tripType') == 'oneway' ? 'checked' : '' }} onchange="toggleReturnDate()">
                                <span class="option-text">ذهاب فقط</span>
                            </label>
                            <label class="trip-type-option">
                                <input type="radio" name="tripType" value="multicity"
                                    {{ old('tripType') == 'multicity' ? 'checked' : '' }} onchange="toggleReturnDate()">
                                <span class="option-text">متعدد المدن</span>
                            </label>
                        </div>
                        @error('tripType')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Main Search Fields -->
                    <div class="search-fields-grid">
                        <!-- From Location -->
                        <div class="form-group location-group">
                            <label for="from" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                                من
                            </label>
                            <div class="input-wrapper">
                                <select id="from" name="from" class="form-input" required>
                                    <option value="" disabled {{ old('from') ? '' : 'selected' }}>اختر مدينة المغادرة
                                    </option>
                                    @foreach ($airports as $airport)
                                        <option value="{{ $airport->id }}"
                                            {{ old('from') == $airport->id ? 'selected' : '' }}>{{ $airport->city }}
                                            ({{ $airport->code }})</option>
                                    @endforeach
                                </select>
                                <div class="input-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="popular-destinations">
                                <span class="popular-label">وجهات شائعة:</span>
                                <button type="button" class="destination-chip"
                                    onclick="setDestination('from', {{ $airports->where('city', 'الرياض')->first()->id ?? '' }})">الرياض</button>
                                <button type="button" class="destination-chip"
                                    onclick="setDestination('from', {{ $airports->where('city', 'جدة')->first()->id ?? '' }})">جدة</button>
                                <button type="button" class="destination-chip"
                                    onclick="setDestination('from', {{ $airports->where('city', 'دبي')->first()->id ?? '' }})">دبي</button>
                            </div>
                            @error('from')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Swap Button -->
                        <div class="swap-button-container">
                            <button type="button" class="swap-btn" onclick="swapDestinations()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 2l4 4-4 4" />
                                    <path d="M3 6h18" />
                                    <path d="M7 22l-4-4 4-4" />
                                    <path d="M21 18H3" />
                                </svg>
                            </button>
                        </div>

                        <!-- To Location -->
                        <div class="form-group location-group">
                            <label for="to" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                                إلى
                            </label>
                            <div class="input-wrapper">
                                <select id="to" name="to" class="form-input" required>
                                    <option value="" disabled {{ old('to') ? '' : 'selected' }}>اختر مدينة الوصول
                                    </option>
                                    @foreach ($airports as $airport)
                                        <option value="{{ $airport->id }}"
                                            {{ old('to') == $airport->id ? 'selected' : '' }}>{{ $airport->city }}
                                            ({{ $airport->code }})</option>
                                    @endforeach
                                </select>
                                <div class="input-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="popular-destinations">
                                <span class="popular-label">وجهات شائعة:</span>
                                <button type="button" class="destination-chip"
                                    onclick="setDestination('to', {{ $airports->where('city', 'القاهرة')->first()->id ?? '' }})">القاهرة</button>
                                <button type="button" class="destination-chip"
                                    onclick="setDestination('to', {{ $airports->where('city', 'اسطنبول')->first()->id ?? '' }})">اسطنبول</button>
                                <button type="button" class="destination-chip"
                                    onclick="setDestination('to', {{ $airports->where('city', 'لندن')->first()->id ?? '' }})">لندن</button>
                            </div>
                            @error('to')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Date and Passenger Selection -->
                    <div class="date-passenger-grid">
                        <!-- Departure Date -->
                        <div class="form-group">
                            <label for="depart" class="form-label">
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
                                <input type="date" id="depart" name="depart" class="form-input date-input"
                                    value="{{ old('depart') }}" required>
                            </div>
                            @error('depart')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Return Date -->
                        <div class="form-group" id="returnDateGroup"
                            style="{{ old('tripType', 'roundtrip') == 'oneway' ? 'display: none;' : '' }}">
                            <label for="return" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                تاريخ العودة
                            </label>
                            <div class="input-wrapper">
                                <input type="date" id="return" name="return" class="form-input date-input"
                                    value="{{ old('return') }}">
                            </div>
                            @error('return')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Passengers -->
                        <div class="form-group">
                            <label for="passengers" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                عدد الركاب
                            </label>
                            <div class="passenger-selector">
                                <button type="button" class="passenger-btn" onclick="changePassengers(-1)">-</button>
                                <input type="number" id="passengers" name="passengers" class="passenger-input"
                                    min="1" max="9" value="{{ old('passengers', 1) }}" readonly>
                                <button type="button" class="passenger-btn" onclick="changePassengers(1)">+</button>
                            </div>
                            @error('passengers')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Class Selection -->
                        <div class="form-group">
                            <label for="class" class="form-label">
                                <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polygon
                                        points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                </svg>
                                درجة السفر
                            </label>
                            <div class="input-wrapper">
                                <select id="class" name="class" class="form-input">
                                    <option value="Economy" {{ old('class', 'Economy') == 'Economy' ? 'selected' : '' }}>
                                        الدرجة الاقتصادية</option>
                                    <option value="Business" {{ old('class') == 'Business' ? 'selected' : '' }}>درجة رجال
                                        الأعمال</option>
                                    <option value="First" {{ old('class') == 'First' ? 'selected' : '' }}>الدرجة الأولى
                                    </option>
                                </select>
                            </div>
                            @error('class')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Advanced Options -->
                    <div class="advanced-options">
                        <button type="button" class="advanced-toggle" onclick="toggleAdvanced()">
                            <span>خيارات متقدمة</span>
                            <svg class="toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="6,9 12,15 18,9" />
                            </svg>
                        </button>

                        <div class="advanced-content" id="advancedContent" style="display: none;">
                            <div class="advanced-grid">
                                <div class="form-group">
                                    <label for="airline" class="form-label">شركة الطيران المفضلة</label>
                                    <select id="airline" name="airline" class="form-input">
                                        <option value="" {{ old('airline') ? '' : 'selected' }}>جميع شركات الطيران
                                        </option>
                                        @foreach ($airlines as $airline)
                                            <option value="{{ $airline->id }}"
                                                {{ old('airline') == $airline->id ? 'selected' : '' }}>
                                                {{ $airline->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">نوع الرحلة</label>
                                    <div class="checkbox-group">
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="directFlight" value="1"
                                                {{ old('directFlight') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            رحلات مباشرة فقط
                                        </label>
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="flexibleDates" value="1"
                                                {{ old('flexibleDates') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            تواريخ مرنة
                                        </label>
                                    </div>
                                </div>
                            </div>
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
                                <span class="btn-text">ابحث عن الرحلات</span>
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

            <!-- Flight Search Results -->
            @if (isset($flights) && $flights->isNotEmpty())
                <div class="flight-results">
                    <h3 class="results-title">نتائج البحث:
                        {{ $searchParams['from'] ? $airports->find($searchParams['from'])->city : '' }} إلى
                        {{ $searchParams['to'] ? $airports->find($searchParams['to'])->city : '' }}</h3>
                    <div class="results-grid">
                        @foreach ($flights as $flight)
                            <div class="flight-card">
                                <div class="flight-card-header">
                                    <img src="{{ asset('images/airlines/' . ($flight->airline->img ?? 'default.png')) }}"
                                        alt="{{ $flight->airline->name }}" class="airline-logo">
                                    <span class="flight-number">{{ $flight->flight_number }}</span>
                                </div>
                                <div class="flight-card-content">
                                    <div class="flight-details">
                                        <div class="flight-time">
                                            <span>{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</span>
                                            <span>{{ $flight->departureAirport->city }}
                                                ({{ $flight->departureAirport->code }})</span>
                                        </div>
                                        <div class="flight-duration">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                            <span>{{ $flight->duration }}</span>
                                            <span
                                                class="flight-stops">{{ $flight->stops == 'direct' ? 'مباشر' : ($flight->stops == 'one-stop' ? 'توقف واحد' : 'توقفات متعددة') }}</span>
                                        </div>
                                        <div class="flight-time">
                                            <span>{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</span>
                                            <span>{{ $flight->arrivalAirport->city }}
                                                ({{ $flight->arrivalAirport->code }})</span>
                                        </div>
                                    </div>
                                    <div class="flight-price">
                                        <span>{{ number_format($flight->price, 2) }} ريال</span>
                                        <span
                                            class="flight-class">{{ $flight->class == 'Economy' ? 'اقتصادية' : ($flight->class == 'Business' ? 'رجال الأعمال' : 'الأولى') }}</span>
                                    </div>
                                </div>
                                <div class="flight-card-footer">
                                    <a href="{{ route('flights.book', $flight->id) }}" class="book-btn">
                                        <span>احجز الآن</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif(isset($flights))
                <p class="no-results">لا توجد رحلات متاحة لهذا البحث. حاول تعديل التواريخ أو الوجهة.</p>
            @endif

            <!-- Return Flights (for round-trip) -->
            @if (isset($returnFlights) && $returnFlights->isNotEmpty())
                <div class="flight-results">
                    <h3 class="results-title">رحلات العودة:
                        {{ $searchParams['to'] ? $airports->find($searchParams['to'])->city : '' }} إلى
                        {{ $searchParams['from'] ? $airports->find($searchParams['from'])->city : '' }}</h3>
                    <div class="results-grid">
                        @foreach ($returnFlights as $flight)
                            <div class="flight-card">
                                <div class="flight-card-header">
                                    <img src="{{ asset('images/airlines/' . ($flight->airline->img ?? 'default.png')) }}"
                                        alt="{{ $flight->airline->name }}" class="airline-logo">
                                    <span class="flight-number">{{ $flight->flight_number }}</span>
                                </div>
                                <div class="flight-card-content">
                                    <div class="flight-details">
                                        <div class="flight-time">
                                            <span>{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</span>
                                            <span>{{ $flight->departureAirport->city }}
                                                ({{ $flight->departureAirport->code }})</span>
                                        </div>
                                        <div class="flight-duration">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                            <span>{{ $flight->duration }}</span>
                                            <span
                                                class="flight-stops">{{ $flight->stops == 'direct' ? 'مباشر' : ($flight->stops == 'one-stop' ? 'توقف واحد' : 'توقفات متعددة') }}</span>
                                        </div>
                                        <div class="flight-time">
                                            <span>{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</span>
                                            <span>{{ $flight->arrivalAirport->city }}
                                                ({{ $flight->arrivalAirport->code }})</span>
                                        </div>
                                    </div>
                                    <div class="flight-price">
                                        <span>{{ number_format($flight->price, 2) }} ريال</span>
                                        <span
                                            class="flight-class">{{ $flight->class == 'Economy' ? 'اقتصادية' : ($flight->class == 'Business' ? 'رجال الأعمال' : 'الأولى') }}</span>
                                    </div>
                                </div>
                                <div class="flight-card-footer">
                                    <a href="{{ route('flights.book', $flight->id) }}" class="book-btn">
                                        <span>احجز الآن</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif(isset($returnFlights))
                <p class="no-results">لا توجد رحلات عودة متاحة. حاول تعديل تاريخ العودة.</p>
            @endif
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        function toggleReturnDate() {
            const tripType = document.querySelector('input[name="tripType"]:checked').value;
            document.getElementById('returnDateGroup').style.display = tripType === 'oneway' ? 'none' : 'block';
        }

        function setDestination(field, airportId) {
            document.getElementById(field).value = airportId;
        }

        function swapDestinations() {
            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;
            document.getElementById('from').value = to;
            document.getElementById('to').value = from;
        }

        function changePassengers(delta) {
            const input = document.getElementById('passengers');
            let value = parseInt(input.value);
            value = Math.max(1, Math.min(9, value + delta));
            input.value = value;
        }

        function toggleAdvanced() {
            const content = document.getElementById('advancedContent');
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        }

        function quickSearch(fromId, toId) {
            document.getElementById('from').value = fromId;
            document.getElementById('to').value = toId;
            document.getElementById('flightSearchForm').submit();
        }
    </script>
@endsection



@section('styles')
    <style>
        /* Existing styles from the original file */
        /* ... */

        /* Success Alert Styles */
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
        // Existing scripts from the original file
        // ...

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
