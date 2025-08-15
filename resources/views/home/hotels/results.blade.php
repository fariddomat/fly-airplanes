@extends('layouts.site')

@section('title', $title ?? 'نتائج بحث الفنادق - منصة السفر')
@section('description', $description ?? 'نتائج بحث الفنادق')

@section('content')
    <!-- Results Header -->
    <section class="hotel-search-hero">
        <div class="hero-particles"></div>
        <div class="container">
            <div class="search-header">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="separator">←</span>
                    <a href="{{ route('hotels.search') }}">حجز الفنادق</a>
                    <span class="separator">←</span>
                    <span class="current">نتائج البحث</span>
                </div>

                <h1 class="page-title">
                    <span class="title-icon">🏨</span>
                    نتائج بحث الفنادق
                </h1>
                <p class="page-subtitle">اختر من بين الفنادق المتاحة في {{ $searchParams['destination'] }}</p>

                <div class="search-summary">
                    <div class="route-info">
                        <div class="route-details">
                            <h2 class="route-title">
                                <span class="destination-city">{{ $searchParams['destination'] }}</span>
                                <svg class="car-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21h18"/>
                                    <path d="M5 21V7l8-4v18"/>
                                    <path d="M19 21V11l-6-4"/>
                                    <path d="M9 9v.01"/>
                                    <path d="M9 12v.01"/>
                                    <path d="M9 15v.01"/>
                                    <path d="M9 18v.01"/>
                                </svg>
                            </h2>
                            <div class="trip-details">
                                <span class="checkin-info">
                                    الوصول: {{ \Carbon\Carbon::parse($searchParams['checkin'])->translatedFormat('d F Y') }}
                                </span>
                                <span class="checkout-info">
                                    المغادرة: {{ \Carbon\Carbon::parse($searchParams['checkout'])->translatedFormat('d F Y') }}
                                </span>
                                <span class="duration-info">{{ $stayNights }} ليالي</span>
                                <span class="guests-info">{{ $searchParams['guests'] }} نزلاء، {{ $searchParams['rooms'] }} غرفة</span>
                            </div>
                        </div>
                        <a href="{{ route('hotels.search') }}" class="modify-search-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            تعديل البحث
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Content -->
    <section class="car-results-content">
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
                        <h4 class="filter-title">السعر (ريال/ليلة)</h4>
                        <div class="price-range">
                            <div class="price-inputs">
                                <input type="number" id="minPrice" name="minPrice" placeholder="من" min="0" value="{{ old('minPrice', $searchParams['minPrice'] ?? 100) }}">
                                <span class="price-separator">-</span>
                                <input type="number" id="maxPrice" name="maxPrice" placeholder="إلى" min="0" value="{{ old('maxPrice', $searchParams['maxPrice'] ?? 2000) }}">
                            </div>
                            <div class="price-slider">
                                <input type="range" id="priceRange" min="100" max="2000" value="{{ old('maxPrice', $searchParams['maxPrice'] ?? 2000) }}" class="slider">
                                <div class="price-labels">
                                    <span>100 ريال</span>
                                    <span>2000 ريال</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Star Rating Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">تصنيف الفندق</h4>
                        <div class="filter-options">
                            @foreach([5 => '⭐⭐⭐⭐⭐', 4 => '⭐⭐⭐⭐', 3 => '⭐⭐⭐'] as $value => $label)
                                <label class="filter-option">
                                    <input type="checkbox" name="stars[]" value="{{ $value }}" {{ in_array($value, old('stars', $searchParams['stars'] ?? [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <div class="star-info">
                                        <span class="star-rating">{{ $label }}</span>
                                        <span class="car-count">{{ \App\Models\Hotel::where('star_rating', $value)->where('city', 'like', '%' . $searchParams['destination'] . '%')->count() }} فنادق</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hotel Type Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">نوع الإقامة</h4>
                        <div class="filter-options">
                            @foreach(['hotel' => 'فندق', 'resort' => 'منتجع', 'apartment' => 'شقة فندقية', 'villa' => 'فيلا'] as $value => $label)
                                <label class="filter-option">
                                    <input type="checkbox" name="type[]" value="{{ $value }}" {{ in_array($value, old('type', $searchParams['type'] ?? [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Amenities Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">المرافق</h4>
                        <div class="filter-options">
                            @foreach(['wifi' => 'واي فاي مجاني', 'pool' => 'مسبح', 'gym' => 'صالة رياضية', 'spa' => 'سبا'] as $value => $label)
                                <label class="filter-option">
                                    <input type="checkbox" name="amenities[]" value="{{ $value }}" {{ in_array($value, old('amenities', $searchParams['amenities'] ?? [])) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <!-- Results Main Content -->
                <main class="results-main">
                    <!-- Sort and View Options -->
                    <div class="results-toolbar">
                        <div class="results-count">
                            <span class="count-text">تم العثور على <strong>{{ $hotels->total() }} فندق</strong></span>
                        </div>
                        <div class="sort-options">
                            <label for="sortBy">ترتيب حسب:</label>
                            <select id="sortBy" name="sortBy" onchange="updateSort(this.value)">
                                <option value="price" {{ old('sortBy', $searchParams['sortBy'] ?? 'price') == 'price' ? 'selected' : '' }}>السعر (الأقل أولاً)</option>
                                <option value="rating" {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'rating' ? 'selected' : '' }}>التقييم</option>
                                <option value="popular" {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'popular' ? 'selected' : '' }}>الأكثر شعبية</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden Form for Filters -->
                    <form id="filterForm" action="{{ route('hotels.search') }}" method="POST">
                        @csrf
                        <input type="hidden" name="destination" value="{{ $searchParams['destination'] }}">
                        <input type="hidden" name="checkin" value="{{ $searchParams['checkin'] }}">
                        <input type="hidden" name="checkout" value="{{ $searchParams['checkout'] }}">
                        <input type="hidden" name="guests" value="{{ $searchParams['guests'] }}">
                        <input type="hidden" name="rooms" value="{{ $searchParams['rooms'] }}">
                        <input type="hidden" name="starRating" value="{{ $searchParams['starRating'] ?? '' }}">
                        <input type="hidden" name="priceRange" value="{{ $searchParams['priceRange'] ?? '' }}">
                        <input type="hidden" name="hotelType" value="{{ $searchParams['hotelType'] ?? '' }}">
                        @foreach($searchParams['amenities'] ?? [] as $amenity)
                            <input type="hidden" name="amenities[]" value="{{ $amenity }}">
                        @endforeach
                        @foreach($searchParams['stars'] ?? [] as $star)
                            <input type="hidden" name="stars[]" value="{{ $star }}">
                        @endforeach
                        @foreach($searchParams['type'] ?? [] as $type)
                            <input type="hidden" name="type[]" value="{{ $type }}">
                        @endforeach
                        <input type="hidden" name="minPrice" id="minPriceHidden">
                        <input type="hidden" name="maxPrice" id="maxPriceHidden">
                        <input type="hidden" name="sortBy" id="sortByHidden">
                    </form>

                    <!-- Hotel Results -->
                    <div class="cars-list" id="hotelsList">
                        @forelse($hotels as $hotel)
                            <div class="car-card" data-price="{{ $hotel->price_per_night }}" data-rating="{{ $hotel->rating ?? 4.0 }}" data-type="{{ $hotel->type ?? 'hotel' }}">
                                <div class="car-header">
                                    <div class="car-image">
                                        <img src="{{ Storage::url($hotel->image) }}" alt="{{ $hotel->name }}">
                                        <div class="car-badge {{ $hotel->type ?? 'hotel' }}">
                                            {{ ['hotel' => 'فندق', 'resort' => 'منتجع', 'apartment' => 'شقة فندقية', 'villa' => 'فيلا'][$hotel->type ?? 'hotel'] }}
                                        </div>
                                    </div>
                                    <div class="car-basic-info">
                                        <h3 class="car-name">{{ $hotel->name }}</h3>
                                        <div class="car-location">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="max-width:15px;">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            {!! $hotel->address !!}, {{ $hotel->city }}
                                        </div>
                                        <div class="car-rating">
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span>{{ $i <= floor($hotel->rating ?? 4.0) ? '⭐' : '' }}</span>
                                                @endfor
                                            </div>
                                            <span class="rating-text">{{ number_format($hotel->rating ?? 4.0, 1) }} ({{ rand(50, 500) }} تقييم)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="car-details">
                                    <div class="car-amenities">
                                        @foreach($hotel->amenities ?? [] as $amenity)
                                            <div class="amenity">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M9 12l2 2 4-4"/>
                                                    <circle cx="12" cy="12" r="10"/>
                                                </svg>
                                                <span>{{ ['wifi' => 'واي فاي مجاني', 'pool' => 'مسبح', 'gym' => 'صالة رياضية', 'spa' => 'سبا'][$amenity] ?? $amenity }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="room-info">
                                        <div class="room-type">{{ $hotel->room_type ?? 'غرفة قياسية' }}</div>
                                        <div class="room-features">
                                            <span>{{ $hotel->room_type == 'غرفة ديلوكس' ? 'سرير كينغ' : 'سرير مزدوج' }}</span>
                                            <span>{{ $hotel->room_type == 'غرفة ديلوكس' ? '35 متر مربع' : '20-28 متر مربع' }}</span>
                                            <span>إفطار مجاني</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="car-pricing">
                                    <div class="price-info">
                                        <div class="price">{{ number_format($hotel->price_per_night, 2) }} ريال</div>
                                        <div class="price-note">لليلة الواحدة</div>
                                        <div class="total-price">المجموع: {{ number_format($hotel->price_per_night * $stayNights, 2) }} ريال ({{ $stayNights }} ليالي)</div>
                                        @if($hotels->min('price_per_night') == $hotel->price_per_night)
                                            <div class="lowest-price">أقل سعر!</div>
                                        @elseif($hotels->sortBy('price_per_night')->slice(1, 1)->first()->price_per_night == $hotel->price_per_night)
                                            <div class="best-value">أفضل قيمة!</div>
                                        @endif
                                    </div>
                                    <button class="book-btn {{ $hotel->type ?? 'hotel' }}" onclick="openHotelBookingModal('{{ $hotel->id }}', '{{ $hotel->name }}', '{!! $hotel->address !!}', '{{ $hotel->price_per_night }}', '{{ $hotel->city }}', '{{ $searchParams['checkin'] }}', '{{ $searchParams['checkout'] }}', '{{ $hotel->room_type ?? 'غرفة قياسية' }}', '{{ str_repeat('⭐', $hotel->star_rating) }}', '{{ $hotel->rating ?? 4.0 }}')">
                                        <span>احجز الآن</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p>لا توجد فنادق متاحة تطابق معايير البحث.</p>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        {{ $hotels->links() }}
                    </div>
                </main>
            </div>
        </div>
    </section>

    <!-- Payment Modal -->
    <div id="hotel-booking-modal" class="payment-modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>تأكيد الحجز</h3>
                <button class="close-modal" onclick="closeHotelBookingModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="selected-hotel-info">
                    <h4 id="selected-hotel-name"></h4>
                    <div class="booking-details">
                        <div class="detail">
                            <span>الموقع:</span>
                            <span id="selected-hotel-location"></span>
                        </div>
                        <div class="detail">
                            <span>السعر اليومي:</span>
                            <span id="daily-price"></span>
                        </div>
                        <div class="detail">
                            <span>المدة:</span>
                            <span>{{ $stayNights }} ليالي</span>
                        </div>
                        <div class="detail total">
                            <span>المجموع:</span>
                            <span id="total-price"></span>
                        </div>
                    </div>
                </div>

                <form class="payment-form" action="{{ route('hotels.book') }}" method="POST">
                    @csrf
                    <input type="hidden" id="hotel-id" name="hotel_id">
                    <input type="hidden" id="hotel-name-input" name="hotel_name">
                    <input type="hidden" id="total-price-input" name="total_price">
                    <input type="hidden" name="check_in_date" value="{{ $searchParams['checkin'] }}">
                    <input type="hidden" name="check_out_date" value="{{ $searchParams['checkout'] }}">
                    <input type="hidden" name="room_type" id="room-type-input">
                    <input type="hidden" name="guests" value="{{ $searchParams['guests'] }}">
                    <input type="hidden" name="rooms" value="{{ $searchParams['rooms'] }}">

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
                            <input type="text" id="card-name" name="card_name" placeholder="الاسم كما يظهر على البطاقة">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="closeHotelBookingModal()">إلغاء</button>
                        <button type="submit" class="confirm-btn">تأكيد الحجز</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
  position: relative;
  overflow: hidden;
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
        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 2rem;
            font-weight: 700;
        }
        .page-subtitle {
            font-size: 1.2rem;
            color: #666;
        }
        .search-summary {
            margin-top: 20px;
        }
        .route-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .route-title {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .car-icon {
            width: 20px;
            height: 20px;
            margin: 0 10px;
        }
        .trip-details {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .trip-details span {
            font-size: 0.9rem;
        }
        .modify-search-btn {
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .modify-search-btn:hover {
            background: #0056b3;
        }
        .car-results-content {
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
        .price-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .price-inputs input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100px;
        }
        .price-slider {
            margin-top: 10px;
        }
        .slider {
            width: 100%;
        }
        .price-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }
        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .filter-option {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .star-info {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .checkmark {
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .results-main {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .results-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .results-count {
            font-size: 1.2rem;
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
        .cars-list {
            display: grid;
            gap: 20px;
        }
        .car-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }
        .car-header {
            display: flex;
            gap: 20px;
        }
        .car-image {
            position: relative;
        }
        .car-image img {
            width: 200px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }
        .car-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #28a745;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .car-basic-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .car-name {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .car-location {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .car-location svg {
            width: 16px;
            height: 16px;
        }
        .car-rating {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .stars {
            display: flex;
            gap: 5px;
        }
        .car-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .car-amenities, .room-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .amenity, .room-features span {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .amenity svg {
            width: 16px;
            height: 16px;
        }
        .room-type {
            font-weight: 700;
        }
        .car-pricing {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .price-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .price {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .price-note {
            font-size: 0.9rem;
            color: #666;
        }
        .total-price {
            font-size: 1.2rem;
        }
        .lowest-price, .best-value {
            background: #28a745;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            width: fit-content;
        }
        .book-btn {
            padding: 10px 20px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .book-btn:hover {
            background: #218838;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .payment-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .selected-hotel-info {
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
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
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
        .cancel-btn, .confirm-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-btn {
            background: #dc3545;
            color: #fff;
        }
        .confirm-btn {
            background: #28a745;
            color: #fff;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function clearAllFilters() {
            document.getElementById('filterForm').reset();
            document.getElementById('minPrice').value = '';
            document.getElementById('maxPrice').value = '';
            document.getElementById('filterForm').submit();
        }

        function updateSort(value) {
            document.getElementById('sortByHidden').value = value;
            document.getElementById('minPriceHidden').value = document.getElementById('minPrice').value;
            document.getElementById('maxPriceHidden').value = document.getElementById('maxPrice').value;
            document.getElementById('filterForm').submit();
        }

        function openHotelBookingModal(id, name, location, dailyPrice, city, checkin, checkout, roomType, stars, rating) {
            document.getElementById('selected-hotel-name').textContent = name;
            document.getElementById('selected-hotel-location').textContent = location + ', ' + city;
            document.getElementById('daily-price').textContent = dailyPrice + ' ريال';
            document.getElementById('total-price').textContent = (dailyPrice * {{ $stayNights }}) + ' ريال';
            document.getElementById('hotel-id').value = id;
            document.getElementById('hotel-name-input').value = name;
            document.getElementById('total-price-input').value = dailyPrice * {{ $stayNights }};
            document.getElementById('room-type-input').value = roomType;
            document.getElementById('hotel-booking-modal').style.display = 'flex';
        }

        function closeHotelBookingModal() {
            document.getElementById('hotel-booking-modal').style.display = 'none';
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

        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                document.getElementById('minPriceHidden').value = document.getElementById('minPrice').value;
                document.getElementById('maxPriceHidden').value = document.getElementById('maxPrice').value;
                document.getElementById('sortByHidden').value = document.getElementById('sortBy').value;
                document.getElementById('filterForm').submit();
            });
        });
    </script>
@endsection
