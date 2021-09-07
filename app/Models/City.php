<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SecureDelete;

class City extends Model
{
    use SecureDelete, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'name', 'quantity'
    ];

    protected $relationships = [
        'stores'
    ];

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeIn($query, $cities)
    {
        return $query->whereIn('id', $cities);
    }

    public static function listCities()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
