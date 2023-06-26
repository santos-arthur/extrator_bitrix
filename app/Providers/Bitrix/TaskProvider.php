<?php

namespace App\Providers\Bitrix;

use App\Jobs\Bitrix\Task\TaskRestQueue;
use App\Models\Bitrix;
use Illuminate\Support\ServiceProvider;

class TaskProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public static function import()
    {
        foreach (explode(',', $_ENV['BITRIX_WORKGROUP']) as $group){
            $tasks = Bitrix::call('tasks.task.list', [
                'filter' => [
                    'GROUP_ID' => $group
                ],
                'select' => [
                    'ID'
                ]
            ]);

            TaskRestQueue::dispatch($tasks['total'], $group);
        }
    }
}
