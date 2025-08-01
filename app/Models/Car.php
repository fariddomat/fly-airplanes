<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rentalcompany_id',
        'name',
        'year',
        'type',
        'transmission',
        'fuel_type',
        'price',
        'img',
        'seats',
        'luggage_capacity',
        'features',
        'rating',
    ];

    protected $casts = [
        'features' => 'array', // Store features as JSON
        'rating' => 'float',
    ];

    protected $searchable = ['name', 'type', 'transmission', 'fuel_type', 'price'];

    public static function rules()
    {
        return [
            'rentalcompany_id' => 'required|exists:rentalcompanies,id',
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'type' => 'required|in:economy,compact,sedan,suv,luxury,van,convertible',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'price' => 'required|numeric|min:0',
            'img' => 'nullable|string|max:255',
            'seats' => 'required|integer|min:1',
            'luggage_capacity' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'rating' => 'nullable|numeric|min:0|max:5',
        ];
    }

    public function rentalcompany()
    {
        return $this->belongsTo(Rentalcompany::class, 'rentalcompany_id');
    }

    public function getFormattedFeaturesAttribute()
    {
        return collect($this->features)->map(fn($feature) => match($feature) {
            'air_conditioning' => 'تكييف',
            'gps' => 'نظام GPS',
            'leather_seats' => 'مقاعد جلدية',
            'bluetooth' => 'بلوتوث',
            'rear_camera' => 'كاميرا خلفية',
            'touch_screen' => 'شاشة لمس',
            'premium_audio' => 'نظام صوتي متقدم',
            'sunroof' => 'فتحة سقف',
            default => $feature,
        })->toArray();
    }
}
