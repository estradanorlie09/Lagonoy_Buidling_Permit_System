<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApplicationRemark extends Model
{
    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['zoning_application_id', 'sanitary_application_id', 'officer_id', 'remark'];

    protected $table = 'application_remark';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function application()
    {
        return $this->belongsTo(ZoningApplication::class, 'zoning_application_id');
    }

    public function zoningApplication()
    {
        return $this->belongsTo(ZoningApplication::class, 'zoning_application_id');
    }

    public function application_sanitary()
    {
        return $this->belongsTo(SanitaryApplication::class, 'sanitary_application_id');
    }
}
