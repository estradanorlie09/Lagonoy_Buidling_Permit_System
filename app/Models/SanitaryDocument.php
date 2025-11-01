<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SanitaryDocument extends Model
{
    use HasFactory;

    // protected $table = 'zoning_document';
    protected $fillable = [
        'sanitary_application_id',
        'approved_id',
        'document_type',
        'version',
        'file_path',
        'status',
        'remarks',
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
        return $this->belongsTo(SanitaryApplication::class, 'zoning_application_id');
    }
}
