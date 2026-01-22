<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocChecklist extends Model
{
    protected $table = 'document_submissions';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'application_id',
        'document_key',
        'is_submitted',
        'submitted_at',
        'submitted_by',
        'remarks',
    ];

    protected $casts = [
        'is_submitted' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
