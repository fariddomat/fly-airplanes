<?php

namespace App\Http\Controllers;



use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\Car;
use App\Models\RentalCompany;
use App\Models\Airline;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mail;

use App\Models\Airport;
use App\Models\Booking;
use App\Models\Carrental;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    // Home

    public function home()
    {
        try {
            return view('home.index');
        } catch (\Exception $e) {
            \Log::error('HomeController Error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            return response('Internal Server Error', 500);
        }
    }

    /**
     * Display the flight search page.
     *
     * @return \Illuminate\View\View
     */
    public function showFlightSearch()
    {
        $airports = Airport::all(); // Fetch all airports for dropdowns
        $airlines = \App\Models\Airline::all(); // Fetch all airlines for advanced options
        return view('home.flights.search', [
            'title' => 'بحث الطيران - منصة السفر',
            'description' => 'ابحث عن رحلات الطيران بأفضل الأسعار مع منصة السفر',
            'airports' => $airports,
            'airlines' => $airlines,
        ]);
    }


    /**
     * Process the flight search request and display results.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function searchFlights(Request $request)
    {
        $request->validate([
            'tripType' => 'required|in:oneway,roundtrip,multicity',
            'from' => 'required|exists:airports,id',
            'to' => 'required|exists:airports,id|different:from',
            'depart' => 'required|date|after_or_equal:today',
            'return' => 'nullable|date|after_or_equal:depart',
            'passengers' => 'required|integer|min:1|max:9',
            'class' => 'required|in:Economy,Business,First',
            'airline' => 'nullable|exists:airlines,id',
            'directFlight' => 'nullable|boolean',
            'flexibleDates' => 'nullable|boolean',
            'minPrice' => 'nullable|numeric|min:0',
            'maxPrice' => 'nullable|numeric|min:0',
            'airlines' => 'nullable|array',
            'airlines.*' => 'exists:airlines,id',
            'departureTimes' => 'nullable|array',
            'departureTimes.*' => 'in:morning,afternoon,evening',
            'stops' => 'nullable|in:direct,one-stop,multi-stop',
            'sortBy' => 'nullable|in:price,duration,departure,airline',
        ]);

        $query = Flight::query()
            ->where('departure_airport_id', $request->from)
            ->where('arrival_airport_id', $request->to)
            ->whereDate('departure_time', $request->depart)
            ->where('class', $request->class)
            ->where('available_seats', '>=', $request->passengers);

        // Apply filters
        if ($request->minPrice) {
            $query->where('price', '>=', $request->minPrice);
        }
        if ($request->maxPrice) {
            $query->where('price', '<=', $request->maxPrice);
        }
        if ($request->airlines) {
            $query->whereIn('airline_id', $request->airlines);
        }
        if ($request->departureTimes) {
            $query->where(function ($q) use ($request) {
                foreach ($request->departureTimes as $time) {
                    if ($time === 'morning') {
                        $q->orWhereBetween('departure_time', [
                            Carbon::parse($request->depart)->setTime(6, 0),
                            Carbon::parse($request->depart)->setTime(11, 59, 59),
                        ]);
                    } elseif ($time === 'afternoon') {
                        $q->orWhereBetween('departure_time', [
                            Carbon::parse($request->depart)->setTime(12, 0),
                            Carbon::parse($request->depart)->setTime(17, 59, 59),
                        ]);
                    } elseif ($time === 'evening') {
                        $q->orWhereBetween('departure_time', [
                            Carbon::parse($request->depart)->setTime(18, 0),
                            Carbon::parse($request->depart)->setTime(23, 59, 59),
                        ]);
                    }
                }
            });
        }
        if ($request->stops) {
            $query->where('stops', $request->stops);
        }
        if ($request->directFlight) {
            $query->where('stops', 'direct');
        }
        if ($request->flexibleDates) {
            $departDate = Carbon::parse($request->depart);
            $query->whereBetween('departure_time', [
                $departDate->copy()->subDays(3)->startOfDay(),
                $departDate->copy()->addDays(3)->endOfDay(),
            ]);
        }

        // Apply sorting
        $sortBy = $request->sortBy ?? 'price';
        if ($sortBy === 'price') {
            $query->orderBy('price', 'asc');
        } elseif ($sortBy === 'duration') {
            $query->orderByRaw("CAST(SUBSTRING(duration, 1, LOCATE('س', duration) - 1) AS UNSIGNED) ASC");
        } elseif ($sortBy === 'departure') {
            $query->orderBy('departure_time', 'asc');
        } elseif ($sortBy === 'airline') {
            $query->orderBy(Airline::select('name')->whereColumn('airlines.id', 'flights.airline_id'), 'asc');
        }

        $flights = $query->with(['airline', 'departureAirport', 'arrivalAirport'])->paginate(10);

        $returnFlights = null;
        if ($request->tripType === 'roundtrip' && $request->return) {
            $returnQuery = Flight::query()
                ->where('departure_airport_id', $request->to)
                ->where('arrival_airport_id', $request->from)
                ->whereDate('departure_time', $request->return)
                ->where('class', $request->class)
                ->where('available_seats', '>=', $request->passengers)
                ->when($request->airlines, fn($q) => $q->whereIn('airline_id', $request->airlines))
                ->when($request->stops, fn($q) => $q->where('stops', $request->stops))
                ->when($request->directFlight, fn($q) => $q->where('stops', 'direct'))
                ->when($request->flexibleDates, fn($q) => $q->whereBetween('departure_time', [
                    Carbon::parse($request->return)->subDays(3)->startOfDay(),
                    Carbon::parse($request->return)->addDays(3)->endOfDay(),
                ]))
                ->when($request->departureTimes, fn($q) => $q->where(function ($q2) use ($request) {
                    foreach ($request->departureTimes as $time) {
                        if ($time === 'morning') {
                            $q2->orWhereBetween('departure_time', [
                                Carbon::parse($request->return)->setTime(6, 0),
                                Carbon::parse($request->return)->setTime(11, 59, 59),
                            ]);
                        } elseif ($time === 'afternoon') {
                            $q2->orWhereBetween('departure_time', [
                                Carbon::parse($request->return)->setTime(12, 0),
                                Carbon::parse($request->return)->setTime(17, 59, 59),
                            ]);
                        } elseif ($time === 'evening') {
                            $q2->orWhereBetween('departure_time', [
                                Carbon::parse($request->return)->setTime(18, 0),
                                Carbon::parse($request->return)->setTime(23, 59, 59),
                            ]);
                        }
                    }
                }));

            // Apply same sorting for return flights
            if ($sortBy === 'price') {
                $returnQuery->orderBy('price', 'asc');
            } elseif ($sortBy === 'duration') {
                $returnQuery->orderByRaw("CAST(SUBSTRING(duration, 1, LOCATE('س', duration) - 1) AS UNSIGNED) ASC");
            } elseif ($sortBy === 'departure') {
                $returnQuery->orderBy('departure_time', 'asc');
            } elseif ($sortBy === 'airline') {
                $returnQuery->orderBy(Airline::select('name')->whereColumn('airlines.id', 'flights.airline_id'), 'asc');
            }

            $returnFlights = $returnQuery->with(['airline', 'departureAirport', 'arrivalAirport'])->paginate(10);
        }

        $airports = Airport::all();
        $airlines = Airline::all();
        $flightCounts = [];
        foreach ($airlines as $airline) {
            $flightCounts[$airline->id] = Flight::where('airline_id', $airline->id)
                ->where('departure_airport_id', $request->from)
                ->where('arrival_airport_id', $request->to)
                ->whereDate('departure_time', $request->depart)
                ->where('class', $request->class)
                ->where('available_seats', '>=', $request->passengers)
                ->count();
        }

        return view('home.flights.results', [
            'title' => 'نتائج بحث الطيران - منصة السفر',
            'description' => 'نتائج بحث رحلات الطيران من ' . ($request->from ? Airport::find($request->from)->city : '') . ' إلى ' . ($request->to ? Airport::find($request->to)->city : ''),
            'flights' => $flights,
            'returnFlights' => $returnFlights,
            'searchParams' => $request->all(),
            'airports' => $airports,
            'airlines' => $airlines,
            'flightCounts' => $flightCounts,
        ]);
    }

    public function bookFlight(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'return_flight_id' => 'nullable|exists:flights,id',
            'flight_name' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'from' => 'required|string',
            'to' => 'required|string',
            'depart_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:depart_date',
            'passengers' => 'required|integer|min:1',
            'class' => 'required|in:Economy,Business,First',
            'trip_type' => 'required|in:oneway,roundtrip,multicity',
            'payment_method' => 'required|in:visa,mastercard,mada,cash',
            'card_number' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'expiry' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'cvv' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'card_name' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
        ]);

        $flight = Flight::findOrFail($request->flight_id);
        $totalPrice = $flight->price * $request->passengers;

        // Handle return flight for roundtrip
        if ($request->trip_type === 'roundtrip' && $request->return_flight_id) {
            $returnFlight = Flight::findOrFail($request->return_flight_id);
            $totalPrice += $returnFlight->price * $request->passengers;
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'flight_id' => $request->flight_id,
            'return_flight_id' => $request->return_flight_id,
            'num_passengers' => $request->passengers,
            'booking_date' => now(),
            'total_price' => $totalPrice,
            'status' => 'Pending',
            'trip_type' => $request->trip_type,
            'passenger_details' => json_encode([
                'name' => $request->card_name ?? Auth::user()->name,
                'email' => Auth::user()->email,
                'payment_method' => $request->payment_method,
                'card_number' => $request->payment_method !== 'cash' ? substr($request->card_number, -4) : null,
            ]),
        ]);


        return redirect()->route('flights.search')->with('success', 'تم إنشاء الحجز بنجاح، في انتظار تأكيد الدفع.');
    }

    public function showCarSearch()
    {
        $airports = Airport::all();
        $rentalCompanies = RentalCompany::all();
        return view('home.cars.search', [
            'title' => 'بحث تأجير السيارات - منصة السفر',
            'description' => 'ابحث عن سيارات للإيجار بأفضل الأسعار في سوريا ودول عربية أخرى',
            'airports' => $airports,
            'rentalCompanies' => $rentalCompanies,
        ]);
    }

    public function searchCars(Request $request)
    {
        $request->validate([
            'rentalType' => 'required|in:same-location,different-location',
            'pickupLocation' => 'required|string',
            'dropoffLocation' => 'nullable|string',
            'pickupDate' => 'required|date|after_or_equal:today',
            'pickupTime' => 'required|string',
            'dropoffDate' => 'required|date|after_or_equal:pickupDate',
            'dropoffTime' => 'required|string',
            'carType' => 'nullable|in:economy,compact,sedan,suv,luxury,van,convertible',
            'transmission' => 'nullable|in:automatic,manual',
            'fuelType' => 'nullable|in:petrol,diesel,hybrid,electric',
            'driverAge' => 'required|in:21-24,25-29,30-64,65+',
            'gps' => 'nullable|boolean',
            'childSeat' => 'nullable|boolean',
            'additionalDriver' => 'nullable|boolean',
            'insurance' => 'nullable|boolean',
            'minPrice' => 'nullable|numeric|min:0',
            'maxPrice' => 'nullable|numeric|min:0',
            'rentalCompanies' => 'nullable|array',
            'rentalCompanies.*' => 'exists:rentalcompanies,id',
            'features' => 'nullable|array',
            'sortBy' => 'nullable|in:price-low,price-high,rating,popular',
        ]);

        $query = Car::query()->with('rentalCompany');

        $query->whereHas('rentalCompany', function ($q) use ($request) {
            $q->where('address', 'like', '%' . $request->pickupLocation . '%');
        });

        if ($request->carType) {
            $query->where('type', $request->carType);
        }

        if ($request->transmission) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->fuelType) {
            $query->where('fuel_type', $request->fuelType);
        }

        if ($request->minPrice) {
            $query->where('price', '>=', $request->minPrice);
        }
        if ($request->maxPrice) {
            $query->where('price', '<=', $request->maxPrice);
        }

        if ($request->rentalCompanies) {
            $query->whereIn('rentalcompany_id', $request->rentalCompanies);
        }

        if ($request->features) {
            foreach ($request->features as $feature) {
                $query->whereJsonContains('features', $feature);
            }
        }

        $pickupDateTime = Carbon::parse($request->pickupDate . ' ' . $request->pickupTime);
        $dropoffDateTime = Carbon::parse($request->dropoffDate . ' ' . $request->dropoffTime);
        $rentalDays = $pickupDateTime->diffInDays($dropoffDateTime) + 1;

        $sortBy = $request->sortBy ?? 'price-low';
        if ($sortBy === 'price-low') {
            $query->orderBy('price', 'asc');
        } elseif ($sortBy === 'price-high') {
            $query->orderBy('price', 'desc');
        } elseif ($sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($sortBy === 'popular') {
            $query->orderBy('id', 'asc');
        }

        $cars = $query->paginate(10);

        $airports = Airport::all();
        $rentalCompanies = RentalCompany::all();
        $carCounts = [];
        foreach ($rentalCompanies as $company) {
            $carCounts[$company->id] = Car::where('rentalcompany_id', $company->id)
                ->whereHas('rentalCompany', fn($q) => $q->where('address', 'like', '%' . $request->pickupLocation . '%'))
                ->count();
        }

        return view('home.cars.results', [
            'title' => 'نتائج بحث تأجير السيارات - منصة السفر',
            'description' => 'نتائج بحث تأجير السيارات في ' . $request->pickupLocation,
            'cars' => $cars,
            'searchParams' => $request->all(),
            'airports' => $airports,
            'rentalCompanies' => $rentalCompanies,
            'carCounts' => $carCounts,
            'rentalDays' => $rentalDays,
        ]);
    }

    public function bookCar(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'car_name' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'pickup_location' => 'required|string',
            'return_location' => 'nullable|string',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|string',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'dropoff_time' => 'required|string',
            'rental_type' => 'required|in:same-location,different-location',
            'driver_age' => 'required|in:21-24,25-29,30-64,65+',
            'extras' => 'nullable|json',
            'payment_method' => 'required|in:visa,mastercard,mada,cash',
            'card_number' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'expiry' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'cvv' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'card_name' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
        ]);

        $car = Car::findOrFail($request->car_id);
        $pickupDateTime = Carbon::parse($request->pickup_date . ' ' . $request->pickup_time);
        $dropoffDateTime = Carbon::parse($request->return_date . ' ' . $request->dropoff_time);
        $rentalDays = $pickupDateTime->diffInDays($dropoffDateTime) + 1;

        // Calculate extra costs
        $extras = json_decode($request->extras, true) ?? [];
        $extraCosts = 0;
        $extraPrices = [
            'gps' => 25,
            'childSeat' => 15,
            'additionalDriver' => 30,
            'insurance' => 50,
        ];
        foreach ($extras as $extra) {
            if (isset($extraPrices[$extra])) {
                $extraCosts += $extraPrices[$extra] * $rentalDays;
            }
        }

        $totalPrice = ($car->price * $rentalDays) + $extraCosts;

        $carRental = Carrental::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'return_date' => $request->return_date,
            'dropoff_time' => $request->dropoff_time,
            'total_price' => $totalPrice,
            'booking_date' => now(),
            'status' => 'Pending',
            'rental_type' => $request->rental_type,
            'driver_age' => $request->driver_age,
            'extras' => $request->extras,
            'driver_details' => json_encode([
                'name' => $request->card_name ?? Auth::user()->name,
                'payment_method' => $request->payment_method,
                'card_number' => $request->payment_method !== 'cash' ? substr($request->card_number, -4) : null,
            ]),
        ]);

        // TODO: Implement payment processing (e.g., Stripe) here
        // For now, assume booking is pending until payment is confirmed

        return redirect()->route('cars.search')->with('success', 'تم إنشاء الحجز بنجاح، في انتظار تأكيد الدفع.');
    }


    public function showHotelSearch()
    {
        return view('home.hotels.search', [
            'title' => 'بحث الفنادق - منصة السفر',
            'description' => 'ابحث عن فنادق بأفضل الأسعار في جميع أنحاء العالم',
        ]);
    }

    public function searchHotels(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
            'guests' => 'required|integer|min:1|max:10',
            'rooms' => 'required|integer|min:1|max:5',
            'starRating' => 'nullable|in:3,4,5',
            'priceRange' => 'nullable|in:budget,mid,luxury',
            'hotelType' => 'nullable|in:hotel,resort,apartment,villa',
            'amenities' => 'nullable|array',
            'stars' => 'nullable|array',
            'stars.*' => 'in:3,4,5',
            'type' => 'nullable|array',
            'type.*' => 'in:hotel,resort,apartment,villa',
            'minPrice' => 'nullable|numeric|min:0',
            'maxPrice' => 'nullable|numeric|min:0',
            'sortBy' => 'nullable|in:price,rating,popular',
        ]);

        $query = Hotel::query();

        // Filter by destination (city or hotel name)
        $query->where(function ($q) use ($request) {
            $q->where('city', 'like', '%' . $request->destination . '%')
              ->orWhere('name', 'like', '%' . $request->destination . '%');
        });

        // Filter by star rating
        if ($request->starRating) {
            $query->where('star_rating', '>=', $request->starRating);
        }
        if ($request->stars) {
            $query->whereIn('star_rating', $request->stars);
        }

        // Filter by price range
        if ($request->priceRange) {
            if ($request->priceRange == 'budget') {
                $query->where('price_per_night', '<', 200);
            } elseif ($request->priceRange == 'mid') {
                $query->whereBetween('price_per_night', [200, 500]);
            } elseif ($request->priceRange == 'luxury') {
                $query->where('price_per_night', '>', 500);
            }
        }
        if ($request->minPrice) {
            $query->where('price_per_night', '>=', $request->minPrice);
        }
        if ($request->maxPrice) {
            $query->where('price_per_night', '<=', $request->maxPrice);
        }

        // Filter by hotel type
        if ($request->hotelType) {
            $query->where('type', $request->hotelType);
        }
        if ($request->type) {
            $query->whereIn('type', $request->type);
        }

        // Filter by amenities
        if ($request->amenities) {
            foreach ($request->amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Calculate stay duration
        $checkinDate = Carbon::parse($request->checkin);
        $checkoutDate = Carbon::parse($request->checkout);
        $stayNights = $checkinDate->diffInDays($checkoutDate);

        // Sorting
        $sortBy = $request->sortBy ?? 'price';
        if ($sortBy === 'price') {
            $query->orderBy('price_per_night', 'asc');
        } elseif ($sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($sortBy === 'popular') {
            $query->orderBy('id', 'asc'); // Placeholder for popularity
        }

        $hotels = $query->paginate(10);

        return view('home.hotels.results', [
            'title' => 'نتائج بحث الفنادق - منصة السفر',
            'description' => 'نتائج بحث الفنادق في ' . $request->destination,
            'hotels' => $hotels,
            'searchParams' => $request->all(),
            'stayNights' => $stayNights,
        ]);
    }

    public function bookHotel(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'hotel_name' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_type' => 'nullable|string',
            'guests' => 'required|integer|min:1|max:10',
            'rooms' => 'required|integer|min:1|max:5',
            'payment_method' => 'required|in:visa,mastercard,mada,cash',
            'card_number' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'expiry' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'cvv' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
            'card_name' => 'required_if:payment_method,visa,mastercard,mada|string|nullable',
        ]);

        $hotel = Hotel::findOrFail($request->hotel_id);
        $checkinDate = Carbon::parse($request->check_in_date);
        $checkoutDate = Carbon::parse($request->check_out_date);
        $stayNights = $checkinDate->diffInDays($checkoutDate);

        // Calculate total price (base price * nights * rooms)
        $totalPrice = $hotel->price_per_night * $stayNights * $request->rooms;

        $hotelBooking = HotelBooking::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'room_type' => $request->room_type,
            'total_price' => $totalPrice,
            'booking_date' => now(),
            'status' => 'Pending',
            'payment_details' => json_encode([
                'payment_method' => $request->payment_method,
                'card_number' => $request->payment_method !== 'cash' ? substr($request->card_number, -4) : null,
                'card_name' => $request->card_name ?? Auth::user()->name,
            ]),
        ]);

        // TODO: Implement payment processing (e.g., Stripe) here
        // For now, assume booking is pending until payment is confirmed

        return redirect()->route('hotels.search')->with('success', 'تم إنشاء الحجز بنجاح، في انتظار تأكيد الدفع.');
    }

}
