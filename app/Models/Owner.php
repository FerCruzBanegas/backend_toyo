<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'uuid', 'names', 'surnames', 'phone', 'ci', 'address', 'verified', 'user_id', 'store_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) \Uuid::generate(4);
        });
    }

    public function getFullnameAttribute()
    {
       return "{$this->names} {$this->surnames}";
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeIn($query, $owners)
    {
        return $query->whereIn('id', $owners);
    }

    public static function listOwners()
    {
        return static::orderBy('id', 'DESC')->select('id', DB::raw("CONCAT(names,' ',surnames) AS name"))->get();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
}
