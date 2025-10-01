<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ZoningProperty extends Model
{
    use HasFactory;

    protected $table = 'zoning_property';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'property_address',
        'province',
        'municipality',
        'barangay',
        'lot_area',
        'tax_declaration',
        'comments',
        'ownership_type',
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
        return $this->hasMany(ZoningApplication::class, 'property_id');
    }
}
