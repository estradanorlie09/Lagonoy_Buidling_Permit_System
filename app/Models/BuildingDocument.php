<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BuildingDocument extends Model
{
    use HasFactory;

    // protected $table = 'zoning_document';
    protected $fillable = [
        'building_application_id',
        'document_type',
        'version',
        'file_path',
    ];

    public $incrementing = false; // UUID not auto-increment

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function application()
    {
        return $this->belongsTo(BuildingApplication::class, 'building_application_id');
    }
}
