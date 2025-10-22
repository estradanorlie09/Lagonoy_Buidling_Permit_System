<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ZoningDocument extends Model
{
    use HasFactory;
    //protected $table = 'zoning_document'; 
    protected $fillable = [
        'zoning_application_id',
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
        return $this->belongsTo(ZoningApplication::class, 'zoning_application_id');
    }
}
