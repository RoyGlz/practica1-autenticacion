<?php

namespace App\Traits;

use App\Models\Audit;

trait Auditable
{
    public static function bootAuditable()
    {
        self::created(function ($model) {
            self::createAudit($model, 'create', null, $model->getAttributes());
        });

        self::updated(function ($model) {
            $changes = $model->getChanges();
            $oldValues = $model->getOriginal();
            self::createAudit($model, 'update', $oldValues, $changes);
        });

        self::deleted(function ($model) {
            self::createAudit($model, 'delete', $model->getAttributes(), null);
        });
    }

    protected static function createAudit($model, $action, $oldValues, $newValues)
    {
        Audit::create([
            'user_name'  => auth()->user()?->name ?? 'System',
            'model_type' => class_basename($model),
            'model_id'   => $model->id,
            'action'     => $action,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}