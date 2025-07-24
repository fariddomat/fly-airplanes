<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airline extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['airline_name', 'airline_code'];

    public static function rules()
    {
        return [
            'airline_name' => 'required|string|max:255',
            'airline_code' => 'required|string|max:255'
        ];
    }

    protected $searchable = ['airline_name', 'airline_code'];
}