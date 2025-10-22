<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class SanitaryProperty extends Model
{
    use HasFactory;

    protected $table = 'sanitary_property';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'occupancy_type',
        'property_address',
        'province',
        'municipality',
        'barangay',
        'lot_area',
        'comments',
    ];

    // Auto-generate UUID on create
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function applications()
    {
        return $this->hasMany(SanitaryApplication::class, 'property_id');
    }
}
