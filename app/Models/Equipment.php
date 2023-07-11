<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'description',
        'price',
        'photo'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'reservation_equipment')
            ->withPivot('equipmentInformation');
    }
}
