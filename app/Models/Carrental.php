<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrental extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['user_id', 'rentalcompany_id', 'car_id', 'pickup_location', 'return_location', 'pickup_date', 'return_date', 'total_price', 'booking_date', 'status'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'rentalcompany_id' => 'required|exists:rentalcompanies,id',
            'car_id' => 'required|exists:cars,id',
            'pickup_location' => 'required|string',
            'return_location' => 'required|string',
            'pickup_date' => 'required|date',
            'return_date' => 'required|date',
            'total_price' => 'required|numeric',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending'
        ];
    }

    public function User()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function Rentalcompany()
    {
        return $this->belongsTo(\App\Models\Rentalcompany::class, 'rentalcompany_id');
    }
    public function Car()
    {
        return $this->belongsTo(\App\Models\Car::class, 'car_id');
    }
}