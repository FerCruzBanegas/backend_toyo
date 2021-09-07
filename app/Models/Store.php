<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SecureDelete;

class Store extends Model
{
    use SecureDelete, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'uuid', 'code', 'name', 'address', 'phone', 'city_id'
    ];

    protected $relationships = [
        'owners'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) \Uuid::generate(4);
            $model->code = (string) substr(md5(time()), 0, 8);
        });
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function scopeIn($query, $stores)
    {
        return $query->whereIn('id', $stores);
    }

    public static function listStores()
    {
        return static::orderBy('id', 'DESC')->get();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }
}
