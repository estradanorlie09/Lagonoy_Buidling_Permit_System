<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Professional extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'building_application_id',
        'prof_type',
        'prof_name',
        'prc_no',
        'ptr_no',
        'phone_number',
        'email',
        'birthday',
        'prof_address',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function application()
    {
        return $this->belongsTo(BuildingApplication::class, 'building_application_id');
    }
}
