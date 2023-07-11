<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    //protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'surname',
        'skiSchool',
        'experience',
        'price',
        'activity',
        'description',
        'email',
        'password',
        'phoneNumber',
        'status',
        'photo',
        'mountain_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function periods()
    {
        return $this->hasMany(Period::class);
    }
}
