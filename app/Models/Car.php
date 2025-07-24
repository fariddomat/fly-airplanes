<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['rentalcompany_id', 'car_model', 'car_make', 'car_year'];

    public static function rules()
    {
        return [
            'rentalcompany_id' => 'required|exists:rentalcompanies,id',
            'car_model' => 'nullable|string|max:255',
            'car_make' => 'nullable|string|max:255',
            'car_year' => 'required|numeric'
        ];
    }

    protected $searchable = ['car_model', 'car_make'];
    public function Rentalcompany()
    {
        return $this->belongsTo(\App\Models\Rentalcompany::class, 'rentalcompany_id');
    }
}