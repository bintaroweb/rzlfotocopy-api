<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    //

    protected $fillable = [
        'id',
        'name',
        'contact',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'technician_id', 'id');
    }
}
