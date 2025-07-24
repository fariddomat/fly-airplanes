<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class Airport extends Model
{


    use SoftDeletes;
    protected $fillable = ['airport_code', 'airport_name', 'city', 'country', 'latitude', 'longitude'];

    public static function rules()
    {
        return [
            'airport_code' => 'required|string|max:255',
            'airport_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255'
        ];
    }

    protected $searchable = ['airport_code', 'airport_name', 'city', 'country', 'latitude', 'longitude'];
}
