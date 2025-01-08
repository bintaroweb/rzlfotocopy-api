<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Schedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'date',
        'customer_id',
        'technician_id',
        'contact',
        'address',
        'problem',
        "created_by"
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::orderedUuid();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'id');
    }
}
