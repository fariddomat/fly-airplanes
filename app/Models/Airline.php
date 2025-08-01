<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airline extends Model
{
    
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'img'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    protected $searchable = ['name', 'code'];
}