<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrental extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'car_id',
        'pickup_location',
        'return_location',
        'pickup_date',
        'pickup_time',
        'return_date',
        'dropoff_time',
        'total_price',
        'booking_date',
        'status',
        'rental_type',
        'driver_age',
        'extras',
        'driver_details',
    ];

    protected $casts = [
        'extras' => 'array', // Store extras as JSON
        'driver_details' => 'array', // Store driver details as JSON
    ];

    protected $searchable = ['status', 'rental_type', 'pickup_location', 'return_location'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'nullable|string|max:255',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|string|regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'dropoff_time' => 'required|string|regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/',
            'total_price' => 'required|numeric|min:0',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending',
            'rental_type' => 'required|in:same-location,different-location',
            'driver_age' => 'required|in:21-24,25-29,30-64,65+',
            'extras' => 'nullable|array',
            'driver_details' => 'nullable|array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
