<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'totalPrice',
        'period_id',
        'equipment_id',
        'equipmentDescription',
        'user_id',
        'status',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'reservation_equipment')
            ->withPivot('equipmentInformation');
    }
}
