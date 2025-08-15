@extends('layouts.site')

@section('title', $title ?? 'نتائج بحث تأجير السيارات - منصة السفر')
@section('description', $description ?? 'نتائج بحث تأجير السيارات')

@section('content')
    <!-- Results Header -->
    <section class="car-results-header">
        <div class="container">
            <div class="search-header">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="separator">←</span>
                    <a href="{{ route('cars.search') }}">تأجير السيارات</a>
                    <span class="separator">←</span>
                    <span class="current">نتائج البحث</span>
                </div>

                <h1 class="page-title">

                    نتائج تأجير السيارات
                </h1>
                  @if ($errors->any())
                    <div
                        style="background-color: rgb(219, 124, 124); width: 90%; text-align: center; color:white; padding: 2rem; margin-bottom: 1rem; border-radius: 15px">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <p class="page-subtitle">اختر السيارة المناسبة لرحلتك من بين أفضل العروض المتاحة</p>

                <div class="search-summary">
                    <div class="route-info">
                        <div>
                            <h2 class="route-title">
                                {{ $searchParams['pickupLocation'] }}
                                <svg class="route-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                                {{ $searchParams['rentalType'] == 'different-location' && isset($searchParams['dropoffLocation']) ? $searchParams['dropoffLocation'] : $searchParams['pickupLocation'] }}
                            </h2>
                            <div class="trip-details">
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($searchParams['pickupDate'])->translatedFormat('d F Y') }}
                                </span>
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($searchParams['dropoffDate'])->translatedFormat('d F Y') }}
                                </span>
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12,6 12,12 16,14" />
                                    </svg>
                                    {{ $rentalDays }} أيام
                                </span>
                                <span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    سائق واحد
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('cars.search') }}" class="modify-search-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
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
                        <h4 class="filter-title">السعر (ريال سعودي / يوم)</h4>
                        <div class="price-range">
                            <div class="price-inputs">
                                <input type="number" id="minPrice" name="minPrice" placeholder="من" min="0"
                                    max="1000" value="{{ old('minPrice', $searchParams['minPrice'] ?? 50) }}">
                                <span class="price-separator">-</span>
                                <input type="number" id="maxPrice" name="maxPrice" placeholder="إلى" min="0"
                                    max="1000" value="{{ old('maxPrice', $searchParams['maxPrice'] ?? 500) }}">
                            </div>
                            <div class="price-slider">
                                <input type="range" id="priceRange" min="50" max="500"
                                    value="{{ old('maxPrice', $searchParams['maxPrice'] ?? 500) }}" class="slider">
                                <div class="price-labels">
                                    <span>50 ريال</span>
                                    <span>500 ريال</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Car Type Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">نوع السيارة</h4>
                        <div class="filter-options">
                            @foreach ([
            'economy' => 'اقتصادية',
            'compact' => 'مدمجة',
            'sedan' => 'سيدان',
            'suv' => 'دفع رباعي (SUV)',
            'luxury' => 'فاخرة',
            'van' => 'فان عائلي',
            'convertible' => 'مكشوفة',
        ] as $value => $label)
                                <label class="filter-option">
                                    <input type="checkbox" name="carTypes[]" value="{{ $value }}"
                                        {{ in_array($value, old('carTypes', $searchParams['carTypes'] ?? [])) ? 'checked' : '' }}>
                                    <div class="car-type-info">
                                        <span class="car-type-name">{{ $label }}</span>
                                        <span
                                            class="car-count">{{ \App\Models\Car::where('type', $value)->whereHas('rentalCompany', fn($q) => $q->where('address', 'like', '%' . $searchParams['pickupLocation'] . '%'))->count() }}
                                            سيارة</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Rental Company Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">شركة التأجير</h4>
                        <div class="filter-options">
                            @foreach ($rentalCompanies as $company)
                                <label class="filter-option">
                                    <input type="checkbox" name="rentalCompanies[]" value="{{ $company->id }}"
                                        {{ in_array($company->id, old('rentalCompanies', $searchParams['rentalCompanies'] ?? [])) ? 'checked' : '' }}>
                                    <div class="company-info">
                                        <span class="company-name">{{ $company->name }}</span>
                                        <span class="car-count">{{ $carCounts[$company->id] ?? 0 }} سيارة</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Features Filter -->
                    <div class="filter-group">
                        <h4 class="filter-title">المميزات</h4>
                        <div class="filter-options">
                            @foreach (['تكييف', 'نظام GPS', 'مقاعد جلدية', 'بلوتوث', 'شاشة لمس', 'فتحة سقف', 'كاميرا خلفية', 'نظام صوتي متقدم'] as $feature)
                                <label class="filter-option">
                                    <input type="checkbox" name="features[]" value="{{ $feature }}"
                                        {{ in_array($feature, old('features', $searchParams['features'] ?? [])) ? 'checked' : '' }}>
                                    <span>{{ $feature }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <!-- Results Main Content -->
                <main class="results-main">
                    <!-- Results Toolbar -->
                    <div class="results-toolbar">
                        <div class="count-text">
                            <span id="results-count">{{ $cars->total() }}</span> سيارة متاحة
                        </div>
                        <div class="sort-options">
                            <label for="sortBy">ترتيب حسب:</label>
                            <select id="sortBy" name="sortBy" onchange="updateSort(this.value)">
                                <option value="price-low"
                                    {{ old('sortBy', $searchParams['sortBy'] ?? 'price-low') == 'price-low' ? 'selected' : '' }}>
                                    السعر: من الأقل للأعلى</option>
                                <option value="price-high"
                                    {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'price-high' ? 'selected' : '' }}>
                                    السعر: من الأعلى للأقل</option>
                                <option value="rating"
                                    {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'rating' ? 'selected' : '' }}>
                                    التقييم</option>
                                <option value="popular"
                                    {{ old('sortBy', $searchParams['sortBy'] ?? '') == 'popular' ? 'selected' : '' }}>
                                    الأكثر شعبية</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden Form for Filters -->
                    <form id="filterForm" action="{{ route('cars.search') }}" method="POST">
                        @csrf
                        <input type="hidden" name="rentalType" value="{{ $searchParams['rentalType'] }}">
                        <input type="hidden" name="pickupLocation" value="{{ $searchParams['pickupLocation'] }}">
                        <input type="hidden" name="dropoffLocation"
                            value="{{ $searchParams['dropoffLocation'] ?? '' }}">
                        <input type="hidden" name="pickupDate" value="{{ $searchParams['pickupDate'] }}">
                        <input type="hidden" name="pickupTime" value="{{ $searchParams['pickupTime'] }}">
                        <input type="hidden" name="dropoffDate" value="{{ $searchParams['dropoffDate'] }}">
                        <input type="hidden" name="dropoffTime" value="{{ $searchParams['dropoffTime'] }}">
                        <input type="hidden" name="carType" value="{{ $searchParams['carType'] ?? '' }}">
                        <input type="hidden" name="transmission" value="{{ $searchParams['transmission'] ?? '' }}">
                        <input type="hidden" name="fuelType" value="{{ $searchParams['fuelType'] ?? '' }}">
                        <input type="hidden" name="driverAge" value="{{ $searchParams['driverAge'] }}">
                        <input type="hidden" name="gps" value="{{ $searchParams['gps'] ?? '' }}">
                        <input type="hidden" name="childSeat" value="{{ $searchParams['childSeat'] ?? '' }}">
                        <input type="hidden" name="additionalDriver"
                            value="{{ $searchParams['additionalDriver'] ?? '' }}">
                        <input type="hidden" name="insurance" value="{{ $searchParams['insurance'] ?? '' }}">
                        @foreach ($searchParams['rentalCompanies'] ?? [] as $company)
                            <input type="hidden" name="rentalCompanies[]" value="{{ $company }}">
                        @endforeach
                        @foreach ($searchParams['features'] ?? [] as $feature)
                            <input type="hidden" name="features[]" value="{{ $feature }}">
                        @endforeach
                        @foreach ($searchParams['carTypes'] ?? [] as $type)
                            <input type="hidden" name="carTypes[]" value="{{ $type }}">
                        @endforeach
                        <input type="hidden" name="minPrice" id="minPriceHidden">
                        <input type="hidden" name="maxPrice" id="maxPriceHidden">
                        <input type="hidden" name="sortBy" id="sortByHidden">
                    </form>

                    <!-- Cars List -->
                    <div class="cars-list" id="cars-list">
                        @forelse($cars as $car)
                            <div class="car-card" data-price="{{ $car->price }}" data-rating="{{ $car->rating }}"
                                data-type="{{ $car->type }}">
                                <div class="car-header">
                                    <div class="car-image">
                                        <img src="{{ Storage::url($car->img) }}" alt="{{ $car->name }}">
                                        <div class="car-badge {{ $car->type }}">
                                            {{ ['economy' => 'اقتصادية', 'compact' => 'مدمجة', 'sedan' => 'سيدان', 'suv' => 'دفع رباعي', 'luxury' => 'فاخرة', 'van' => 'فان عائلي', 'convertible' => 'مكشوفة'][$car->type] }}
                                        </div>
                                    </div>
                                    <div class="car-basic-info">
                                        <h3 class="car-name">{{ $car->name }}</h3>
                                        <div class="car-company">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                                <polyline points="9 22 9 12 15 12 15 22" />
                                            </svg>
                                            {{ $car->rentalCompany->name }}
                                        </div>
                                        <div class="car-rating">
                                            <div class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg viewBox="0 0 24 24"
                                                        fill="{{ $i <= floor($car->rating / 10) ? 'currentColor' : 'none' }}"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path
                                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="rating-text">{{ number_format($car->rating / 10, 1) }}
                                                ({{ rand(50, 200) }} تقييم)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="car-details">
                                    <div class="car-specs">
                                        <div class="spec">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                            <span>{{ $car->seats }} مقاعد</span>
                                        </div>
                                        <div class="spec">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path
                                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                            </svg>
                                            <span>{{ $car->luggage_capacity }} حقائب</span>
                                        </div>
                                        <div class="spec">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <circle cx="12" cy="12" r="3" />
                                                <path d="M12 1v6m0 6v6" />
                                                <path d="M21 12h-6m-6 0H3" />
                                            </svg>
                                            <span>{{ $car->transmission == 'automatic' ? 'أوتوماتيك' : 'يدوي' }}</span>
                                        </div>
                                        <div class="spec">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M3 12h18l-3-3m0 6l3-3" />
                                                <path d="M19 21V9a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v12" />
                                            </svg>
                                            <span>{{ ['petrol' => 'بنزين', 'diesel' => 'ديزل', 'hybrid' => 'هجين', 'electric' => 'كهربائي'][$car->fuel_type] }}</span>
                                        </div>
                                    </div>

                                    <div class="car-features">
                                        @foreach ($car->features ?? [] as $feature)
                                            <div class="feature">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path d="M20 6L9 17l-5-5" />
                                                </svg>
                                                <span>{{ $feature }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="car-pricing">
                                    <div class="price-info">
                                        <div class="price">{{ number_format($car->price, 2) }} ريال</div>
                                        <div class="price-note">لليوم الواحد</div>
                                        <div class="total-price">المجموع:
                                            {{ number_format($car->price * $rentalDays, 2) }} ريال ({{ $rentalDays }}
                                            أيام)</div>
                                        @if ($cars->min('price') == $car->price)
                                            <div class="best-price">أفضل قيمة</div>
                                        @endif
                                    </div>
                                    <button
                                        class="book-btn {{ strtolower(str_replace(' ', '_', $car->rentalCompany->name)) }}"
                                        onclick="selectCar('{{ $car->id }}', '{{ $car->name }}', '{{ $car->price }}', '{{ $car->price * $rentalDays }}')">
                                        <span>احجز الآن</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p>لا توجد سيارات متاحة تطابق معايير البحث.</p>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        {{ $cars->links() }}
                    </div>
                </main>
            </div>
        </div>
    </section>

    <!-- Payment Modal -->
    <div id="payment-modal" class="payment-modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>تأكيد الحجز</h3>
                <button class="close-modal" onclick="closePaymentModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="selected-car-info">
                    <h4 id="selected-car-name"></h4>
                    <div class="booking-details">
                        <div class="detail">
                            <span>السعر اليومي:</span>
                            <span id="daily-price"></span>
                        </div>
                        <div class="detail">
                            <span>المدة:</span>
                            <span>{{ $rentalDays }} أيام</span>
                        </div>
                        <div class="detail total">
                            <span>المجموع:</span>
                            <span id="total-price"></span>
                        </div>
                    </div>
                </div>

                <form class="payment-form" action="{{ route('cars.book') }}" method="POST">
                    @csrf
                    <input type="hidden" id="car-id" name="car_id">
                    <input type="hidden" id="car-name-input" name="car_name">
                    <input type="hidden" id="total-price-input" name="total_price">
                    <input type="hidden" name="pickup_location" value="{{ $searchParams['pickupLocation'] }}">
                    <input type="hidden" name="return_location"
                        value="{{ $searchParams['rentalType'] == 'different-location' && isset($searchParams['dropoffLocation']) ? $searchParams['dropoffLocation'] : $searchParams['pickupLocation'] }}">
                    <input type="hidden" name="pickup_date" value="{{ $searchParams['pickupDate'] }}">
                    <input type="hidden" name="pickup_time" value="{{ $searchParams['pickupTime'] }}">
                    <input type="hidden" name="return_date" value="{{ $searchParams['dropoffDate'] }}">
                    <input type="hidden" name="dropoff_time" value="{{ $searchParams['dropoffTime'] }}">
                    <input type="hidden" name="rental_type" value="{{ $searchParams['rentalType'] }}">
                    <input type="hidden" name="driver_age" value="{{ $searchParams['driverAge'] }}">
                    <input type="hidden" name="extras" id="extras-input"
                        value="{{ json_encode(
                            array_filter([
                                isset($searchParams['gps']) ? 'gps' : null,
                                isset($searchParams['childSeat']) ? 'childSeat' : null,
                                isset($searchParams['additionalDriver']) ? 'additionalDriver' : null,
                                isset($searchParams['insurance']) ? 'insurance' : null,
                            ]),
                        ) }}">

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
                        <input type="text" id="card-number" name="card_number" maxlength="19"
                            placeholder="xxxx xxxx xxxx xxxx">

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
                            <input type="text" id="card-name" name="card_name"
                                placeholder="الاسم كما يظهر على البطاقة">
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
        .car-results-header {
            background: #f8f9fa;
            padding: 40px 0;
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

        .route-arrow {
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
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .trip-details svg {
            width: 16px;
            height: 16px;
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

        .car-type-info,
        .company-info {
            display: flex;
            justify-content: space-between;
            width: 100%;
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

        .count-text {
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

        .car-company {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .car-company svg {
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

        .stars svg {
            width: 16px;
            height: 16px;
        }

        .car-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .car-specs,
        .car-features {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .spec,
        .feature {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .spec svg,
        .feature svg {
            width: 16px;
            height: 16px;
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

        .best-price {
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

        .book-btn svg {
            width: 16px;
            height: 16px;
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

        .selected-car-info {
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

        .payment-form select,
        .payment-form input {
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

        .cancel-btn,
        .confirm-btn {
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

        function selectCar(carId, carName, dailyPrice, totalPrice) {
            document.getElementById('selected-car-name').textContent = carName;
            document.getElementById('daily-price').textContent = dailyPrice + ' ريال';
            document.getElementById('total-price').textContent = totalPrice + ' ريال';
            document.getElementById('car-id').value = carId;
            document.getElementById('car-name-input').value = carName;
            document.getElementById('total-price-input').value = totalPrice;
            document.getElementById('payment-modal').style.display = 'flex';
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').style.display = 'none';
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
