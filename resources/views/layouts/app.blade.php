<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    livewire:navigate>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <title>{{ config('app.name', 'Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('noty/noty.css') }}">
    <script src="{{ asset('noty/noty.min.js') }}" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        html[dir="rtl"] th {
            text-align: right;
        }

        @media (max-width: 768px) {
            html[dir="rtl"] .main-b {
                margin-left: 0 !important;
                margin-right: -16rem !important;
            }

            html[dir="rtl"] .-translate-x-64 {
                --tw-translate-x: +16rem;
            }

        }

        @media (min-width: 768px) {
            html[dir="rtl"] aside {
                left: unset !important;
            }

            html[dir="ltr"] .main-b {
                margin-left: 16rem !important;
                margin-right: 0 !important;
            }

            html[dir="rtl"] .main-b {
                margin-left: 0 !important;
                margin-right: 16rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen  overflow-x-hidden" x-data="{ open: false }">
        <!-- Sidebar Overlay (Mobile) -->
        <div class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden" x-show="open" @click="open = false"></div>
        <aside
            class="bg-gray-900 text-white p-5 w-64 md:w-64 md:fixed md:top-0 md:left-0 md:h-screen transition-all duration-300 ease-in-out z-50 overflow-y-auto"
            :class="open ? 'translate-x-0' : '-translate-x-64 md:translate-x-0'">
            <h2 class="text-xl font-bold mb-4">@lang('site.control_panel')</h2>

            <nav class="mt-5 space-y-3">
                 <x-responsive-nav-link href="{{ route('home') }}">
                    @lang('site.home') <i class="fas fa-home"></i>
                </x-responsive-nav-link>

                <!-- Dashboard -->
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    لوحة التحكم <i class="fas fa-dashboard"></i>
                </x-responsive-nav-link>

                <!-- Users (Superadministrator Only) -->
                @role('superadministrator')
                    <x-responsive-nav-link href="{{ route('dashboard.users.index') }}" :active="request()->routeIs('dashboard.users.*')">
                        @lang('site.users') <i class="fas fa-users"></i>
                    </x-responsive-nav-link>
                @endrole

                <!-- Travel Group (Admin and Superadmin Only) -->
                @role('administrator|superadministrator')
                    @php
                        $isTravelActive = request()->routeIs([
                            'dashboard.airports.*',
                            'dashboard.airlines.*',
                            'dashboard.flights.*',
                            'dashboard.bookings.*',
                        ]);
                    @endphp
                    <details class="group" {{ $isTravelActive ? 'open' : '' }}>
                        <summary
                            class="{{ $isTravelActive ? 'block w-full ps-4 pe-4 py-2 border-l-4 border-white shadow-md text-start text-base font-medium text-white bg-blue-800 dark:bg-blue-800 rounded-md transition duration-200 ease-in-out flex justify-between items-center' : 'cursor-pointer block w-full ps-4 pe-4 py-2 rounded-lg border border-white/20 shadow-md shadow-gray-800/50 transition-all duration-200 hover:bg-gray-700 active:bg-gray-600 border-l-4 border-transparent text-start text-base font-medium text-gray-300 rounded-md transition duration-200 ease-in-out flex justify-between items-center' }}">
                            @lang('site.travel') <i class="fas fa-plane"></i>
                        </summary>
                        <div class="pl-6 space-y-2 py-2">
                            <x-responsive-nav-link href="{{ route('dashboard.airports.index') }}" :active="request()->routeIs('dashboard.airports.*')">
                                @lang('site.airports') <i class="fas fa-plane-departure"></i>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('dashboard.airlines.index') }}" :active="request()->routeIs('dashboard.airlines.*')">
                                @lang('site.airlines') <i class="fas fa-plane"></i>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('dashboard.flights.index') }}" :active="request()->routeIs('dashboard.flights.*')">
                                @lang('site.flights') <i class="fas fa-plane-arrival"></i>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('dashboard.bookings.index') }}" :active="request()->routeIs('dashboard.bookings.*')">
                                @lang('site.bookings') <i class="fas fa-ticket-alt"></i>
                            </x-responsive-nav-link>
                        </div>
                    </details>
                @endrole

                <!-- Car Rental Group (Admin and Superadmin Only) -->
                @role('administrator|superadministrator')
                    @php
                        $isCarRentalActive = request()->routeIs([
                            'dashboard.rentalcompanies.*',
                            'dashboard.cars.*',
                            'dashboard.carrentals.*',
                        ]);
                    @endphp
                    <details class="group" {{ $isCarRentalActive ? 'open' : '' }}>
                        <summary
                            class="{{ $isCarRentalActive ? 'block w-full ps-4 pe-4 py-2 border-l-4 border-white shadow-md text-start text-base font-medium text-white bg-blue-800 dark:bg-blue-800 rounded-md transition duration-200 ease-in-out flex justify-between items-center' : 'cursor-pointer block w-full ps-4 pe-4 py-2 rounded-lg border border-white/20 shadow-md shadow-gray-800/50 transition-all duration-200 hover:bg-gray-700 active:bg-gray-600 border-l-4 border-transparent text-start text-base font-medium text-gray-300 rounded-md transition duration-200 ease-in-out flex justify-between items-center' }}">
                            @lang('site.car_rental') <i class="fas fa-car"></i>
                        </summary>
                        <div class="pl-6 space-y-2 py-2">
                            <x-responsive-nav-link href="{{ route('dashboard.rentalcompanies.index') }}" :active="request()->routeIs('dashboard.rentalcompanies.*')">
                                @lang('site.rental_companies') <i class="fas fa-building"></i>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('dashboard.cars.index') }}" :active="request()->routeIs('dashboard.cars.*')">
                                @lang('site.cars') <i class="fas fa-car-side"></i>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('dashboard.carrentals.index') }}" :active="request()->routeIs('dashboard.carrentals.*')">
                                @lang('site.car_rentals') <i class="fas fa-key"></i>
                            </x-responsive-nav-link>
                        </div>
                    </details>
                @endrole

                <!-- Hotel Group (Admin and Superadmin Only) -->
                @role('administrator|superadministrator')
                    @php
                        $isHotelActive = request()->routeIs(['dashboard.hotels.*', 'dashboard.hotelbookings.*']);
                    @endphp
                    <details class="group" {{ $isHotelActive ? 'open' : '' }}>
                        <summary
                            class="{{ $isHotelActive ? 'block w-full ps-4 pe-4 py-2 border-l-4 border-white shadow-md text-start text-base font-medium text-white bg-blue-800 dark:bg-blue-800 rounded-md transition duration-200 ease-in-out flex justify-between items-center' : 'cursor-pointer block w-full ps-4 pe-4 py-2 rounded-lg border border-white/20 shadow-md shadow-gray-800/50 transition-all duration-200 hover:bg-gray-700 active:bg-gray-600 border-l-4 border-transparent text-start text-base font-medium text-gray-300 rounded-md transition duration-200 ease-in-out flex justify-between items-center' }}">
                            @lang('site.hotels') <i class="fas fa-hotel"></i>
                        </summary>
                        <div class="pl-6 space-y-2 py-2">
                            <x-responsive-nav-link href="{{ route('dashboard.hotels.index') }}" :active="request()->routeIs('dashboard.hotels.*')">
                                @lang('site.hotels') <i class="fas fa-building"></i>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('dashboard.hotelbookings.index') }}" :active="request()->routeIs('dashboard.hotelbookings.*')">
                                @lang('site.hotel_bookings') <i class="fas fa-bed"></i>
                            </x-responsive-nav-link>
                        </div>
                    </details>
                @endrole

                @role('user')
                    <!-- Bookings (All Roles) -->
                    <x-responsive-nav-link href="{{ route('dashboard.bookings.index') }}" :active="request()->routeIs('dashboard.bookings.*')">
                        @lang('site.bookings') <i class="fas fa-ticket-alt"></i>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('dashboard.carrentals.index') }}" :active="request()->routeIs('dashboard.carrentals.*')">
                        @lang('site.car_rentals') <i class="fas fa-key"></i>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('dashboard.hotelbookings.index') }}" :active="request()->routeIs('dashboard.hotelbookings.*')">
                        @lang('site.hotel_bookings') <i class="fas fa-bed"></i>
                    </x-responsive-nav-link>
                @endrole

                <!-- Adds (Admin and Superadmin Only) -->
                {{-- @role('administrator|superadministrator')
                    <x-responsive-nav-link href="{{ route('dashboard.adds.index') }}" :active="request()->routeIs('dashboard.adds.*')">
                        @lang('site.adds') <i class="fas fa-ad"></i>
                    </x-responsive-nav-link>
                @endrole --}}

                <!-- Profile (All Roles) -->
                <x-responsive-nav-link href="{{ route('profile') }}" :active="request()->routeIs('profile')">
                    @lang('site.profile') <i class="fas fa-user-cog"></i>
                </x-responsive-nav-link>
            </nav>
        </aside>

        <div class="container main-b flex-1 flex flex-col -ml-64 md:ml-64" style="padding: 0">

            <!-- Navbar -->
            <header class="bg-blue-800 text-white  shadow p-4 flex justify-between items-center">
                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="md:hidden text-gray-700 text-2xl">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- User Actions -->
                <div class="flex space-x-3 items-center text-lg">
                    {{-- <span class="cursor-pointer hover:text-gray-500pr-2">
                        <i class="fas fa-bell"></i>
                    </span> --}}

                    {{-- <span class="cursor-pointer hover:text-gray-500 pr-2">
                        <i class="fas fa-user"></i> User
                    </span> --}}

                    <!-- Logout Button -->
                    <span class="cursor-pointer hover:text-red-500 pr-2 w-full">
                        <a class="w-full text-start" href="{{ route('dashboard.logout') }}" wire:navigate>
                            <i class="fas fa-sign-out-alt"></i> @lang('site.logout')
                        </a>
                    </span>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include ajaxForm library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    @extends('layouts._noty')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('redirect', (url) => {
                window.location.href = url;
            });
        });
    </script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("textarea").each(function(index) {
                // Skip if the textarea is invalid or hidden (e.g., display: none)
                if (!this || $(this).is(':hidden') || $(this).parents().is(':hidden')) {
                    return true; // Continue to next iteration
                }

                // Assign a unique ID if none exists
                if (!this.id) {
                    this.id = 'textarea-' + index + '-' + Math.random().toString(36).substr(2,
                        9); // Unique ID
                }

                // Initialize CKEditor only if not already initialized
                if (!CKEDITOR.instances[this.id]) {
                    CKEDITOR.replace(this.id, {
                        removeButtons: "About",
                        contentsLangDirection: $(this).attr('dir') || 'rtl'
                    });
                }
            });
        });
    </script>


</body>

</html>
