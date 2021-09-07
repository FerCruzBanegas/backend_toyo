<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'uuid', 'battery_code', 'status', 'owner_id', 'customer_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) \Uuid::generate(4);
        });
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeIn($query, $tickets)
    {
        return $query->whereIn('id', $tickets);
    }

    public function scopeForowner($query)
    {
        $user = auth()->user();
        if ($user->rol === 'user') {
            return $query->where('owner_id', $user->owner->id); 
        } else {
            return $query;  
        }
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function exchanges()
    {
        return $this->belongsToMany(Exchange::class);
    }
}
