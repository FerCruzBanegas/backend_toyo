<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'uuid', 'state', 'quantity', 'delivered', 'reject', 'owner_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) \Uuid::generate(4);
        });
    }

    public function scopePending($query)
    {
        return $query->where('state', true);
    }

    public function scopeReject($query)
    {
        return $query->where('state', 2);
    }

    public function scopeApproved($query)
    {
        return $query->where('state', false);
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeIn($query, $exchanges)
    {
        return $query->whereIn('id', $exchanges);
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

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
