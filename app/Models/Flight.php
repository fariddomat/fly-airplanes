<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{

    use SoftDeletes;

    protected $fillable = ['departure_airport_id', 'arrival_airport_id', 'departure_time', 'arrival_time', 'flight_number', 'price', 'available_seats', 'class'];

    public static function rules()
    {
        return [
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'flight_number' => 'required|string|max:255',
            'price' => 'required|numeric',
            'available_seats' => 'required|numeric',
            'class' => 'required|in:Economy,Business,First'
        ];
    }

    protected $searchable = ['flight_number'];
    public function DepartureAirport()
    {
        return $this->belongsTo(\App\Models\Airport::class, 'departure_airport_id');
    }
    public function ArrivalAirport()
    {
        return $this->belongsTo(\App\Models\Airport::class, 'arrival_airport_id');
    }
}
