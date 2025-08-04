@extends('layouts.site')

@section('title', $title ?? 'نتائج بحث الطيران - منصة السفر')
@section('description', $description ?? 'نتائج بحث رحلات الطيران')

@section('content')
    <!-- Results Header -->
    <section class="results-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <span class="separator">←</span>
                <a href="{{ route('flights.search') }}">بحث الرحلات</a>
                <span class="separator">←</span>
                <span class="current">نتائج البحث</span>
            </div>

            <div class="search-summary">
                <div class="route-info">
                    <div class="route-details">
                        <h1 class="route-title">
                            <span class="from-city">{{ $searchParams['from'] ? $airports->find($searchParams['from'])->city : 'غير محدد' }}</span>
                            <svg class="route-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                            <span class="to-city">{{ $searchParams['to'] ? $airports->find($searchParams['to'])->city : 'غير محدد' }}</span>
                        </h1>
                        <div class="trip-details">
                            <span class="date-info">{{ \Carbon\Carbon::parse($searchParams['depart'])->translatedFormat('l، d F Y') }}</span>
                            <span class="passenger-info">{{ $searchParams['passengers'] }} {{ $searchParams['passengers'] == 1 ? 'راكب' : 'ركاب' }}</span>
                            <span class="class-info">{{ $searchParams['class'] == 'Economy' ? 'الدرجة الاقتصادية' : ($searchParams['class'] == 'Business' ? 'درجة رجال الأعمال' : 'الدرجة الأولى') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('flights.search') }}" class="modify-search-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        تعديل البحث
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Content -->
    <section class="results-content">
        <div class="container">
            <div class="results-layout">
                <!-- Filters Sidebar -->
                <aside class="filters-sidebar">
                    <div class="filters-header">
                        <h3 class="filters-title">تصفية النتائج</h3>
                        <button class="clear-filters" onclick="clearAllFilters()">مسح الكل</button>
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">السعر</h4>
                        <div class="price-range">
                            <div class="price-inputs">
                                <input type="number" id="minPrice" name="minPrice" placeholder="من" min="0" value="{{ old('minPrice', $searchParams['minPrice'] ?? '') }}">
                                <span class="price-separator">-</span>
                                <input type="number" id="maxPrice" name="maxPrice" placeholder="إلى" min="0" value="{{ old('maxPrice', $searchParams['maxPrice'] ?? '') }}">
                            </div>
                            <div class="price-slider">
                                <input type="range" id="priceRange" min="200" max="2000" value="{{ old('maxPrice', $searchParams['maxPrice'] ?? 1000) }}" class="slider">
                                <div class="price-labels">
                                    <span>200 ريال</span>
                                    <span>2000 ريال</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Airlines Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">شركات الطيران</h4>
                        <div class="filter-options">
                            @foreach($airlines as $airline)
                                <label class="filter-option">
                                    <input type="checkbox" name="airlines[]" value="{{ $airline->id }}" {{ in_array($airline->id, old('airlines', $searchParams['airlines'] ?? [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <div class="airline-info">
                                        <span class="airline-name">{{ $airline->name }}</span>
                                        <span class="flight-count">{{ $flightCounts[$airline->id] ?? 0 }} رحلة</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Departure Time Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">وقت المغادرة</h4>
                        <div class="time-filters">
                            <label class="time-option">
                                <input type="checkbox" name="departureTimes[]" value="morning" {{ in_array('morning', old('departureTimes', $searchParams['departureTimes'] ?? [])) ? 'checked' : '' }}>
                                <span class="time-icon">🌅</span>
                                <div class="time-info">
                                    <span class="time-label">الصباح</span>
                                    <span class="time-range">6:00 - 12:00</span>
                                </div>
                            </label>
                            <label class="time-option">
                                <input type="checkbox" name="departureTimes[]" value="afternoon" {{ in_array('afternoon', old('departureTimes', $searchParams['departureTimes'] ?? [])) ? 'checked' : '' }}>
                                <span class="time-icon">☀️</span>
                                <div class="time-info">
                                    <span class="time-label">بعد الظهر</span>
                                    <span class="time-range">12:00 - 18:00</span>
                                </div>
                            </label>
                            <label class="time-option">
                                <input type="checkbox" name="departureTimes[]" value="evening" {{ in_array('evening', old('departureTimes', $searchParams['departureTimes'] ?? [])) ? 'checked' : '' }}>
                                <span class="time-icon">🌆</span>
                                <div class="time-info">
                                    <span class="time-label">المساء</span>
                                    <span class="time-range">18:00 - 24:00</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Stops Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">عدد التوقفات</h4>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="radio" name="stops" value="direct" {{ old('stops', $searchParams['stops'] ?? '') == 'direct' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <span>رحلات مباشرة</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="stops" value="one-stop" {{ old('stops', $searchParams['stops'] ?? '') == 'one-stop' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <span>توقف واحد</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="stops" value="multi-stop" {{ old('stops', $searchParams['stops'] ?? '') == 'multi-stop' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <span>توقفات متعددة</span>
                            </label>
                        </div>
                    </div>
                </aside>

                <!-- Results Main Content -->
                <main class="results-main">
                    <!-- Sort and View Options -->
                    <div class="results-toolbar">
                        <div class="results-count">
                            <span class="count-text">تم العثور على <strong>{{ $flights->total() }} رحلة</strong></span>
                        </div>
                        <div class="sort-options">
                            <label for="sortBy">ترتيب حسب:</label>
                            <select id="sortBy" name="sortBy" onchange="updateSort(this.value)">
                                <option value="price" {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'price' ? 'selected' : '' }}>السعر (الأقل أولاً)</option>
                                <option value="duration" {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'duration' ? 'selected' : '' }}>مدة الرحلة</option>
                                <option value="departure" {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'departure' ? 'selected' : '' }}>وقت المغادرة</option>
                                <option value="airline" {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'airline' ? 'selected' : '' }}>شركة الطيران</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden Form for Filters -->
                    <form id="filterForm" action="{{ route('flights.search') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tripType" value="{{ $searchParams['tripType'] }}">
                        <input type="hidden" name="from" value="{{ $searchParams['from'] }}">
                        <input type="hidden" name="to" value="{{ $searchParams['to'] }}">
                        <input type="hidden" name="depart" value="{{ $searchParams['depart'] }}">
                        <input type="hidden" name="return" value="{{ $searchParams['return'] ?? '' }}">
                        <input type="hidden" name="passengers" value="{{ $searchParams['passengers'] }}">
                        <input type="hidden" name="class" value="{{ $searchParams['class'] }}">
                        <input type="hidden" name="airline" value="{{ $searchParams['airline'] ?? '' }}">
                        <input type="hidden" name="directFlight" value="{{ $searchParams['directFlight'] ?? '' }}">
                        <input type="hidden" name="flexibleDates" value="{{ $searchParams['flexibleDates'] ?? '' }}">
                        @foreach($searchParams['airlines'] ?? [] as $airline)
                            <input type="hidden" name="airlines[]" value="{{ $airline }}">
                        @endforeach
                        @foreach($searchParams['departureTimes'] ?? [] as $time)
                            <input type="hidden" name="departureTimes[]" value="{{ $time }}">
                        @endforeach
                        <input type="hidden" name="stops" value="{{ $searchParams['stops'] ?? '' }}">
                        <input type="hidden" name="minPrice" id="minPriceHidden">
                        <input type="hidden" name="maxPrice" id="maxPriceHidden">
                        <input type="hidden" name="sortBy" id="sortByHidden">
                    </form>

                    <!-- Flight Results -->
                    <div class="flights-list" id="flightsList">
                        @forelse($flights as $flight)
                            <div class="flight-card" data-price="{{ $flight->price }}"
                                 data-flight-id="{{ $flight->id }}"
                                 data-airline="{{ $flight->airline->id }}"
                                 data-departure="{{ \Carbon\Carbon::parse($flight->departure_time)->hour >= 6 && \Carbon\Carbon::parse($flight->departure_time)->hour < 12 ? 'morning' : (\Carbon\Carbon::parse($flight->departure_time)->hour < 18 ? 'afternoon' : 'evening') }}">
                                <div class="flight-header">
                                    <div class="airline-logo">
                                        <img src="{{ asset('images/airlines/' . ($flight->airline->img ?? 'default.png')) }}" alt="{{ $flight->airline->name }}">
                                    </div>
                                    <div class="airline-name">{{ $flight->airline->name }}</div>
                                    <div class="flight-number">{{ $flight->flight_number }}</div>
                                    <div class="flight-badge {{ $flight->stops }}">{{ $flight->stops == 'direct' ? 'مباشرة' : ($flight->stops == 'one-stop' ? 'توقف واحد' : 'توقفات متعددة') }}</div>
                                </div>

                                <div class="flight-details">
                                    <div class="flight-route">
                                        <div class="departure">
                                            <div class="time">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</div>
                                            <div class="airport">{{ $flight->departureAirport->code }}</div>
                                            <div class="city">{{ $flight->departureAirport->city }}</div>
                                        </div>

                                        <div class="flight-path">
                                            <div class="duration">{{ $flight->duration }}</div>
                                            <div class="path-line">
                                                <div class="line"></div>
                                                <svg class="plane-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                                                </svg>
                                            </div>
                                            <div class="stops">{{ $flight->stops == 'direct' ? 'مباشرة' : ($flight->stops == 'one-stop' ? 'توقف واحد' : 'توقفات متعددة') }}</div>
                                        </div>

                                        <div class="arrival">
                                            <div class="time">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</div>
                                            <div class="airport">{{ $flight->arrivalAirport->code }}</div>
                                            <div class="city">{{ $flight->arrivalAirport->city }}</div>
                                        </div>
                                    </div>

                                    <div class="flight-amenities">
                                        @if($flight->amenities)
                                            @foreach(explode(',', $flight->amenities) as $amenity)
                                                <span class="amenity">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="{{ $amenity == 'حقيبة مجانية' ? 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z' : ($amenity == 'وجبة مجانية' || $amenity == 'وجبة خفيفة' ? 'M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9 M13.73 21a2 2 0 0 1-3.46 0' : 'M12 1v6m0 6v6') }}"/>
                                                    </svg>
                                                    {{ $amenity }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="flight-pricing">
                                    <div class="price-info">
                                        <div class="price">{{ number_format($flight->price, 2) }} ريال</div>
                                        <div class="price-note">شامل الضرائب</div>
                                        @if($flights->min('price') == $flight->price)
                                            <div class="lowest-price">أقل سعر!</div>
                                        @endif
                                    </div>
                                    <button class="book-btn" onclick="selectFlight('{{ $flight->id }}', '{{ $flight->airline->name }} ({{ $flight->flight_number }})', '{{ $flight->price }}', '{{ $flight->price * $searchParams['passengers'] }}')">
                                        <span>احجز الآن</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="no-results">لا توجد رحلات متاحة لهذا البحث. حاول تعديل التواريخ أو الوجهة.</p>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        {{ $flights->appends($searchParams)->links() }}
                    </div>

                    <!-- Return Flights -->
                    @if($returnFlights && $returnFlights->isNotEmpty())
                        <div class="flight-results">
                            <h3 class="results-title">رحلات العودة: {{ $searchParams['to'] ? $airports->find($searchParams['to'])->city : '' }} إلى {{ $searchParams['from'] ? $airports->find($searchParams['from'])->city : '' }}</h3>
                            <div class="flights-list">
                                @foreach($returnFlights as $flight)
                                    <div class="flight-card" data-price="{{ $flight->price }}"
                                         data-flight-id="{{ $flight->id }}"
                                         data-airline="{{ $flight->airline->id }}"
                                         data-departure="{{ \Carbon\Carbon::parse($flight->departure_time)->hour >= 6 && \Carbon\Carbon::parse($flight->departure_time)->hour < 12 ? 'morning' : (\Carbon\Carbon::parse($flight->departure_time)->hour < 18 ? 'afternoon' : 'evening') }}">
                                        <div class="flight-header">
                                            <div class="airline-logo">
                                                <img src="{{ asset('images/airlines/' . ($flight->airline->img ?? 'default.png')) }}" alt="{{ $flight->airline->name }}">
                                            </div>
                                            <div class="airline-name">{{ $flight->airline->name }}</div>
                                            <div class="flight-number">{{ $flight->flight_number }}</div>
                                            <div class="flight-badge {{ $flight->stops }}">{{ $flight->stops == 'direct' ? 'مباشرة' : ($flight->stops == 'one-stop' ? 'توقف واحد' : 'توقفات متعددة') }}</div>
                                        </div>

                                        <div class="flight-details">
                                            <div class="flight-route">
                                                <div class="departure">
                                                    <div class="time">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</div>
                                                    <div class="airport">{{ $flight->departureAirport->code }}</div>
                                                    <div class="city">{{ $flight->departureAirport->city }}</div>
                                                </div>

                                                <div class="flight-path">
                                                    <div class="duration">{{ $flight->duration }}</div>
                                                    <div class="path-line">
                                                        <div class="line"></div>
                                                        <svg class="plane-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="stops">{{ $flight->stops == 'direct' ? 'مباشرة' : ($flight->stops == 'one-stop' ? 'توقف واحد' : 'توقفات متعددة') }}</div>
                                                </div>

                                                <div class="arrival">
                                                    <div class="time">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</div>
                                                    <div class="airport">{{ $flight->arrivalAirport->code }}</div>
                                                    <div class="city">{{ $flight->arrivalAirport->city }}</div>
                                                </div>
                                            </div>

                                            <div class="flight-amenities">
                                                @if($flight->amenities)
                                                    @foreach(explode(',', $flight->amenities) as $amenity)
                                                        <span class="amenity">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="{{ $amenity == 'حقيبة مجانية' ? 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z' : ($amenity == 'وجبة مجانية' || $amenity == 'وجبة خفيفة' ? 'M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9 M13.73 21a2 2 0 0 1-3.46 0' : 'M12 1v6m0 6v6') }}"/>
                                                            </svg>
                                                            {{ $amenity }}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flight-pricing">
                                            <div class="price-info">
                                                <div class="price">{{ number_format($flight->price, 2) }} ريال</div>
                                                <div class="price-note">شامل الضرائب</div>
                                                @if($returnFlights->min('price') == $flight->price)
                                                    <div class="lowest-price">أقل سعر!</div>
                                                @endif
                                            </div>
                                            <button class="book-btn" onclick="selectFlight('{{ $flight->id }}', '{{ $flight->airline->name }} ({{ $flight->flight_number }})', '{{ $flight->price }}', '{{ $flight->price * $searchParams['passengers'] }}')">
                                                <span>احجز الآن</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="pagination">
                                {{ $returnFlights->appends($searchParams)->links() }}
                            </div>
                        </div>
                    @elseif($returnFlights)
                        <p class="no-results">لا توجد رحلات عودة متاحة. حاول تعديل تاريخ العودة.</p>
                    @endif
                </main>
            </div>
        </div>
    </section>

    <!-- Payment Modal -->
    <div id="payment-modal" class="payment-modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>تأكيد الحجز ✈️</h3>
                <button class="close-modal" onclick="closePaymentModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="selected-flight-info">
                    <h4 id="selected-flight-name"></h4>
                    <div class="booking-details">
                        <div class="detail">
                            <span>السعر للراكب الواحد:</span>
                            <span id="single-price"></span>
                        </div>
                        <div class="detail">
                            <span>عدد الركاب:</span>
                            <span>{{ $searchParams['passengers'] }} {{ $searchParams['passengers'] == 1 ? 'راكب' : 'ركاب' }}</span>
                        </div>
                        <div class="detail total">
                            <span>المجموع:</span>
                            <span id="total-price"></span>
                        </div>
                    </div>
                </div>

                <form class="payment-form" action="{{ route('flights.book') }}" method="POST">
                    @csrf
                    <input type="hidden" id="flight-id" name="flight_id">
                    <input type="hidden" id="return-flight-id" name="return_flight_id">
                    <input type="hidden" id="flight-name-input" name="flight_name">
                    <input type="hidden" id="total-price-input" name="total_price">
                    <input type="hidden" name="from" value="{{ $searchParams['from'] }}">
                    <input type="hidden" name="to" value="{{ $searchParams['to'] }}">
                    <input type="hidden" name="depart_date" value="{{ $searchParams['depart'] }}">
                    <input type="hidden" name="return_date" value="{{ $searchParams['return'] ?? '' }}">
                    <input type="hidden" name="passengers" value="{{ $searchParams['passengers'] }}">
                    <input type="hidden" name="class" value="{{ $searchParams['class'] }}">
                    <input type="hidden" name="trip_type" value="{{ $searchParams['tripType'] }}">

                    <div class="form-group">
                        <label for="payment-method">طريقة الدفع:</label>
                        <select id="payment-method" name="payment_method" required>
                            <option value="">اختر طريقة الدفع</option>
                            <option value="visa">بطاقة Visa</option>
                            <option value="mastercard">بطاقة Mastercard</option>
                            <option value="mada">بطاقة مدى</option>
                            <option value="cash">الدفع عند الاستلام</option>
                        </select>
                    </div>

                    <div class="form-group" id="card-details" style="display: none;">
                        <label for="card-number">رقم البطاقة:</label>
                        <input type="text" id="card-number" name="card_number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">

                        <div class="card-row">
                            <div class="form-group">
                                <label for="expiry">تاريخ الانتهاء:</label>
                                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV:</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="card-name">اسم حامل البطاقة:</label>
                            <fulfilment_type>text</fulfilment_type>
                            <input type="text" id="card-name" name="card_name" placeholder="الاسم كما يظهر على البطاقة">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="closePaymentModal()">إلغاء</button>
                        <button type="submit" class="confirm-btn">تأكيد الحجز</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .results-header {
            background: #f8f9fa;
            padding: 40px 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .breadcrumb {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .breadcrumb a, .breadcrumb .current {
            color: #333;
            text-decoration: none;
        }
        .breadcrumb .separator {
            margin: 0 10px;
        }
        .search-summary {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .route-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .route-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .route-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8rem;
            font-weight: 700;
        }
        .route-arrow {
            width: 24px;
            height: 24px;
        }
        .trip-details {
            display: flex;
            gap: 20px;
            font-size: 1rem;
            color: #666;
        }
        .modify-search-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .modify-search-btn:hover {
            background: #0056b3;
        }
        .modify-search-btn svg {
            width: 20px;
            height: 20px;
        }
        .results-content {
            padding: 40px 0;
        }
        .results-layout {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 20px;
        }
        .filters-sidebar {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .filters-title {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .clear-filters {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }
        .filter-group {
            margin-bottom: 20px;
        }
        .filter-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .price-range {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .price-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .price-inputs input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        .price-separator {
            color: #666;
        }
        .price-slider {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .slider {
            width: 100%;
        }
        .price-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #666;
        }
        .filter-options, .time-filters {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .filter-option, .time-option {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .checkmark, .radio-mark {
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .radio-mark {
            border-radius: 50%;
        }
        .airline-info, .time-info {
            display: flex;
            flex-direction: column;
        }
        .airline-name, .time-label {
            font-weight: 500;
        }
        .flight-count, .time-range {
            font-size: 0.9rem;
            color: #666;
        }
        .time-icon {
            font-size: 1.2rem;
        }
        .results-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .results-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .results-count {
            font-size: 1rem;
            font-weight: 500;
        }
        .sort-options {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sort-options select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .flights-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .flight-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 20px;
            align-items: center;
        }
        .flight-header {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .airline-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .airline-name {
            font-size: 1.2rem;
            font-weight: 700;
        }
        .flight-number {
            font-size: 0.9rem;
            color: #666;
        }
        .flight-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .flight-badge.direct {
            background: #28a745;
            color: #fff;
        }
        .flight-badge.one-stop {
            background: #ffc107;
            color: #000;
        }
        .flight-badge.multi-stop {
            background: #dc3545;
            color: #fff;
        }
        .flight-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .flight-route {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: center;
        }
        .departure, .arrival {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .time {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .airport {
            font-size: 1.2rem;
            font-weight: 500;
        }
        .city {
            font-size: 0.9rem;
            color: #666;
        }
        .flight-path {
            text-align: center;
        }
        .duration {
            font-size: 1rem;
            font-weight: 500;
        }
        .path-line {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }
        .line {
            width: 100%;
            height: 2px;
            background: #ddd;
        }
        .plane-icon {
            width: 24px;
            height: 24px;
        }
        .stops {
            font-size: 0.9rem;
            color: #666;
        }
        .flight-amenities {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .amenity {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }
        .amenity svg {
            width: 16px;
            height: 16px;
        }
        .flight-pricing {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            gap: 10px;
        }
        .price-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .price {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .price-note {
            font-size: 0.9rem;
            color: #666;
        }
        .lowest-price {
            background: #28a745;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .book-btn {
            background: linear-gradient(135deg, #dc267f, #ff6b35);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 127, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 127, 0.4);
            background: linear-gradient(135deg, #c21e6b, #e55e2e);
        }
        .book-btn svg {
            width: 20px;
            height: 20px;
        }
        .no-results {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            padding: 20px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .results-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .flight-results {
            margin-top: 40px;
        }
        /* Modal Styles */
        .payment-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            text-align: right;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #2c3e50;
        }
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .selected-flight-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .booking-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .detail {
            display: flex;
            justify-content: space-between;
        }
        .detail.total {
            font-weight: 700;
        }
        .payment-form .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        .payment-form select, .payment-form input {
            padding: 12px;
            border: 1px solid rgba(220, 38, 127, 0.3);
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }
        .payment-form select:focus, .payment-form input:focus {
            outline: none;
            border-color: #dc267f;
            box-shadow: 0 0 8px rgba(220, 38, 127, 0.3);
        }
        .card-row {
            display: flex;
            gap: 20px;
        }
        .card-row .form-group {
            flex: 1;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
        }
        .cancel-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            background: #dc3545;
            color: #fff;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
        }
        .confirm-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(135deg, #dc267f, #ff6b35);
            color: white;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 127, 0.3);
        }
        .confirm-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 127, 0.4);
            background: linear-gradient(135deg, #c21e6b, #e55e2e);
        }
        @media (max-width: 768px) {
            .results-layout {
                grid-template-columns: 1fr;
            }
            .flight-card {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .flight-pricing {
                align-items: center;
            }
            .modal-content {
                width: 95%;
                padding: 15px;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        function clearAllFilters() {
            document.getElementById('filterForm').reset();
            document.getElementById('minPrice').value = '';
            document.getElementById('maxPrice').value = '';
            document.getElementById('priceRange').value = 1000;
            document.getElementById('filterForm').submit();
        }

        function updateSort(value) {
            document.getElementById('sortByHidden').value = value;
            document.getElementById('minPriceHidden').value = document.getElementById('minPrice').value;
            document.getElementById('maxPriceHidden').value = document.getElementById('maxPrice').value;
            document.getElementById('filterForm').submit();
        }

        function selectFlight(flightId, flightName, singlePrice, totalPrice) {
            document.getElementById('selected-flight-name').textContent = flightName;
            document.getElementById('single-price').textContent = singlePrice + ' ريال';
            document.getElementById('total-price').textContent = totalPrice + ' ريال';
            document.getElementById('flight-id').value = flightId;
            document.getElementById('flight-name-input').value = flightName;
            document.getElementById('total-price-input').value = totalPrice;
            document.getElementById('payment-modal').style.display = 'flex';
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').style.display = 'none';
            document.querySelector('.payment-form').reset();
        }

        document.getElementById('payment-method').addEventListener('change', function() {
            document.getElementById('card-details').style.display = this.value === 'cash' ? 'none' : 'block';
        });

        document.getElementById('minPrice').addEventListener('change', function() {
            document.getElementById('minPriceHidden').value = this.value;
            document.getElementById('filterForm').submit();
        });

        document.getElementById('maxPrice').addEventListener('change', function() {
            document.getElementById('maxPriceHidden').value = this.value;
            document.getElementById('filterForm').submit();
        });

        document.querySelectorAll('.filter-option input, .time-option input').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });

        window.onclick = function(event) {
            const modal = document.getElementById('payment-modal');
            if (event.target === modal) {
                closePaymentModal();
            }
        };
    </script>
@endsection
