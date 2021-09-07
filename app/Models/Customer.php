<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'uuid', 'names', 'surnames', 'phone', 'ci', 'address'
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

    public static function listCustomers()
    {
        return static::orderBy('id', 'DESC')->select('id', DB::raw("CONCAT(names,' ',surnames) AS name"))->get();
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeIn($query, $customers)
    {
        return $query->whereIn('id', $customers);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
