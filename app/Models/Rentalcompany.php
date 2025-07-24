<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rentalcompany extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'phone_number', 'email'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ];
    }

    protected $searchable = ['name', 'address', 'phone_number', 'email'];
}