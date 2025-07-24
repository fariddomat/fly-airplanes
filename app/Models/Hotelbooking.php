<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotelbooking extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['user_id', 'hotel_id', 'check_in_date', 'check_out_date', 'room_type', 'total_price', 'booking_date', 'status'];

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'hotel_id' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'room_type' => 'nullable|string|max:255',
            'total_price' => 'required|numeric',
            'booking_date' => 'required|date',
            'status' => 'required|in:Confirmed,Cancelled,Pending'
        ];
    }

    protected $searchable = ['room_type'];
    public function User()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function Hotel()
    {
        return $this->belongsTo(\App\Models\Hotel::class, 'hotel_id');
    }
}