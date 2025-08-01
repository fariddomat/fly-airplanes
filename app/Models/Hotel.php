<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['country', 'phone_number', 'email', 'star_rating', 'description', 'price_per_night', 'rating', 'amenities', 'image'];

    public static function rules()
    {
        return [
            'country' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'star_rating' => 'nullable|numeric',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric',
            'rating' => 'required|numeric',
            'amenities' => 'nullable|json',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    protected $searchable = ['country', 'phone_number', 'email', 'description'];
}