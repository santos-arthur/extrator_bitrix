<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'group_id',
        'stage_id',
        'status_id',
        'created_by',
        'created_date',
        'responsible_id',
        'closed_by',
        'closed_date',
        'time_estimate',
        'time_spent',
        'auditors',
        'accomplices',
        'tags',
        'import_leadtimes'
    ];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($task) {
            $task->created_by = $task->setDefaultIfUserNotExists($task->created_by);
            $task->responsible_id = $task->setDefaultIfUserNotExists($task->responsible_id);
            $task->closed_by = $task->setDefaultIfUserNotExists($task->closed_by);
        });
    }

    private function setDefaultIfUserNotExists($userId): int | null
    {
        $user = User::find($userId);

        return $user ? $userId : null;
    }
}
