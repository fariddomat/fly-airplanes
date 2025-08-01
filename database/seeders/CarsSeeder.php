<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rentalcompanies')->insert([
            [
                'name' => 'دمشق لتأجير السيارات',
                'address' => 'شارع المزة، دمشق، سوريا',
                'phone_number' => '+963 11 123 4567',
                'email' => 'info@damascarrent.com',
                'logo' => 'damascus_rent.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'حلب درايف',
                'address' => 'شارع الجامعة، حلب، سوريا',
                'phone_number' => '+963 21 987 6543',
                'email' => 'contact@aleppodrive.com',
                'logo' => 'aleppo_drive.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'عمان ويلز',
                'address' => 'شارع الملك حسين، عمان، الأردن',
                'phone_number' => '+962 6 123 4567',
                'email' => 'book@ammanwheels.com',
                'logo' => 'amman_wheels.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'بيروت كار هايبر',
                'address' => 'شارع الحمراء، بيروت، لبنان',
                'phone_number' => '+961 1 987 6543',
                'email' => 'rent@beirutcarhire.com',
                'logo' => 'beirut_carhire.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'نايل رينتالز',
                'address' => 'كورنيش النيل، القاهرة، مصر',
                'phone_number' => '+20 2 123 4567',
                'email' => 'info@nilerentals.com',
                'logo' => 'nile_rentals.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

         DB::table('cars')->insert([
            [
                'rentalcompany_id' => 1,
                'name' => 'تويوتا كورولا 2024',
                'year' => 2024,
                'type' => 'economy',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price' => 150,
                'img' => 'corolla_2024.png',
                'seats' => 5,
                'luggage_capacity' => 2,
                'features' => json_encode(['تكييف', 'بلوتوث', 'كاميرا خلفية']),
                'rating' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rentalcompany_id' => 2,
                'name' => 'كيا سبورتاج 2024',
                'year' => 2024,
                'type' => 'suv',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price' => 220,
                'img' => 'sportage_2024.png',
                'seats' => 7,
                'luggage_capacity' => 4,
                'features' => json_encode(['تكييف', 'نظام GPS', 'مقاعد جلدية', 'بلوتوث']),
                'rating' => 46,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rentalcompany_id' => 3,
                'name' => 'نيسان سنترا 2024',
                'year' => 2024,
                'type' => 'sedan',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price' => 180,
                'img' => 'sentra_2024.png',
                'seats' => 5,
                'luggage_capacity' => 3,
                'features' => json_encode(['تكييف', 'بلوتوث', 'شاشة لمس']),
                'rating' => 47,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rentalcompany_id' => 4,
                'name' => 'BMW الفئة الخامسة 2024',
                'year' => 2024,
                'type' => 'luxury',
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'price' => 350,
                'img' => 'bmw_series5_2024.png',
                'seats' => 5,
                'luggage_capacity' => 3,
                'features' => json_encode(['مقاعد جلدية', 'نظام GPS', 'نظام صوتي متقدم', 'فتحة سقف']),
                'rating' => 49,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rentalcompany_id' => 5,
                'name' => 'هيونداي اكسنت 2024',
                'year' => 2024,
                'type' => 'compact',
                'transmission' => 'manual',
                'fuel_type' => 'petrol',
                'price' => 120,
                'img' => 'accent_2024.png',
                'seats' => 5,
                'luggage_capacity' => 2,
                'features' => json_encode(['تكييف', 'بلوتوث']),
                'rating' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->addRole(1);

        DB::table('carrentals')->insert([
            [
                'user_id' => $user->id,
                'car_id' => 1,
                'pickup_location' => 'مطار دمشق الدولي',
                'return_location' => 'مطار دمشق الدولي',
                'pickup_date' => '2025-12-15',
                'pickup_time' => '09:00',
                'return_date' => '2025-12-20',
                'dropoff_time' => '09:00',
                'total_price' => 750,
                'booking_date' => now(),
                'status' => 'Confirmed',
                'rental_type' => 'same-location',
                'driver_age' => '30-64',
                'extras' => json_encode(['gps', 'childSeat']),
                'driver_details' => json_encode(['name' => 'محمد أحمد', 'license_number' => 'SY123456']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'car_id' => 3,
                'pickup_location' => 'مطار الملكة علياء الدولي - عمان',
                'return_location' => 'وسط مدينة عمان',
                'pickup_date' => '2025-12-10',
                'pickup_time' => '12:00',
                'return_date' => '2025-12-15',
                'dropoff_time' => '12:00',
                'total_price' => 900,
                'booking_date' => now(),
                'status' => 'Pending',
                'rental_type' => 'different-location',
                'driver_age' => '25-29',
                'extras' => json_encode(['insurance']),
                'driver_details' => json_encode(['name' => 'علي حسين', 'license_number' => 'JO789012']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
