<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ZoningApplication extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    // protected $table = 'zoning_application';

    protected $fillable = [
        'user_id',
        'property_id',
        'application_no',
        'status',
        'approved_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::creating(function ($model) {
            if (empty($model->application_no)) {
                $model->application_no = 'ZN-'.strtoupper(Str::random(8));
            }
        });
    }

    public function documents()
    {
        return $this->hasMany(ZoningDocument::class, 'zoning_application_id');
    }

    public function property()
    {
        return $this->belongsTo(ZoningProperty::class, 'property_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function remarks()
    {
        return $this->hasMany(ApplicationRemark::class, 'zoning_application_id');
    }

    public function visitation()
    {
        return $this->hasOne(Visitation::class, 'zoning_application_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    // public function user() {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

}
