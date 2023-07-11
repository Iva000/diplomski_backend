<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'date',
        'time',
        'price',
        'status',
        'instructor_id',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
