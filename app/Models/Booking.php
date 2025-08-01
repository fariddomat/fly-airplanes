<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'flight_id',
        'return_flight_id',
        'num_passengers',
        'booking_date',
        'total_price',
        'status',
        'trip_type',
        'passenger_details',
    ];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'flight_id' => 'required|exists:flights,id',
            'return_flight_id' => 'nullable|exists:flights,id',
            'num_passengers' => 'required|integer|min:1|max:9',
            'booking_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:Confirmed,Cancelled,Pending',
            'trip_type' => 'required|in:oneway,roundtrip,multicity',
            'passenger_details' => 'nullable|array',
        ];
    }

    protected $searchable = [''];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function flight()
    {
        return $this->belongsTo(\App\Models\Flight::class, 'flight_id');
    }

    public function returnFlight()
    {
        return $this->belongsTo(Flight::class, 'return_flight_id');
    }
}
