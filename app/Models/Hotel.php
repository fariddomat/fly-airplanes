<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'city', 'country', 'phone_number', 'email', 'star_rating', 'description', 'price_per_night', 'rating', 'amenities', 'image'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'star_rating' => 'nullable|numeric',
            'description' => 'nullable|string',
            'price_per_night' => 'nullable|numeric',
            'rating' => 'nullable|numeric',
            'amenities' => 'nullable|json',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    protected $searchable = ['name', 'address', 'city', 'country', 'phone_number', 'email', 'description'];
}