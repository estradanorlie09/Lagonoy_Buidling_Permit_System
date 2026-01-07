<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BuildingProperty extends Model
{
    use HasFactory;

    protected $table = 'building_property';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'occupancy_type',
        'classified_as',
        'project_title',
        'number_of_floor',
        'floor_area',
        'lot_area',
        'estimated_cost',
        'tct_no',
        'fsec_no',
        'fsec_issued_date',
        'floor_area_ratio',
        'scope_of_work',
        'property_address',
        'province',
        'municipality',
        'barangay',
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
        return $this->hasMany(BuildingApplication::class, 'property_id');
    }
}
