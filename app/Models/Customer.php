<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'customer_city',
        'customer_status',
        'latitude',
        'longitude',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::orderedUuid();
        });
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'customer_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'customer_city', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'customer_status', 'id');
    }
}
