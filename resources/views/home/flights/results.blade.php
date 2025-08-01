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
                            <select id="sortBy" name="sortBy" onchange="this.form.submit()">
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
                                    <a href="{{ route('flights.book', $flight->id) }}" class="book-btn {{ strtolower($flight->airline->code) }}">
                                        <span>احجز الآن</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>
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
                                            <a href="{{ route('flights.book', $flight->id) }}" class="book-btn {{ strtolower($flight->airline->code) }}">
                                                <span>احجز الآن</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                                </svg>
                                            </a>
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

        document.getElementById('minPrice').addEventListener('change', function() {
            document.getElementById('minPriceHidden').value = this.value;
            document.getElementById('filterForm').submit();
        });

        document.getElementById('maxPrice').addEventListener('change', function() {
            document.getElementById('maxPriceHidden').value = this.value;
            document.getElementById('filterForm').submit();
        });

        document.getElementById('priceRange').addEventListener('input', function() {
            document.getElementById('maxPrice').value = this.value;
            document.getElementById('maxPriceHidden').value = this.value;
        });

        document.querySelectorAll('.filter-option input, .time-option input').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });

        document.getElementById('sortBy').addEventListener('change', function() {
            document.getElementById('sortByHidden').value = this.value;
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection
