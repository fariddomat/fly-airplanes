<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rentalcompany extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'phone_number', 'email', 'logo'];

    protected $searchable = ['name', 'address', 'phone_number', 'email'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|string|max:255',
        ];
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'rentalcompany_id');
    }
}
