<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Add extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['booking_id', 'insurance_purchased', 'carrental_id', 'hotelbooking_id', 'payment_method'];

    public static function rules()
    {
        return [
            'booking_id' => 'required|exists:bookings,id',
            'insurance_purchased' => 'sometimes|boolean',
            'carrental_id' => 'required|exists:carrentals,id',
            'hotelbooking_id' => 'required|exists:hotelbookings,id',
            'payment_method' => 'required|string|max:255'
        ];
    }

    protected $searchable = ['payment_method'];
    public function Booking()
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id');
    }
    public function Carrental()
    {
        return $this->belongsTo(\App\Models\Carrental::class, 'carrental_id');
    }
    public function Hotelbooking()
    {
        return $this->belongsTo(\App\Models\Hotelbooking::class, 'hotelbooking_id');
    }
}