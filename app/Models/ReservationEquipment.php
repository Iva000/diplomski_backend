<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationEquipment extends Model
{
    use HasFactory;

    protected $table = 'reservation_equipment';

    protected $fillable = [
        'reservation_id',
        'equipment_id',
        'equipmentInformation',
    ];
}
