<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['user_id', 'flight_id', 'num_passengers', 'booking_date', 'total_price', 'status'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'flight_id' => 'required|exists:flights,id',
            'num_passengers' => 'required|numeric',
            'booking_date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:Confirmed,Cancelled,Pending'
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
}