<?php

namespace App\Providers\Bitrix;

use App\Jobs\Bitrix\Leadtime\ImportLeadtime;
use App\Models\Task;
use Illuminate\Support\ServiceProvider;

class LeadtimeProvider extends ServiceProvider
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

    public static function import(): void
    {
        $tasks = Task::where('import_leadtimes', 1)->get()->toArray();
        foreach ($tasks as $task){
            ImportLeadtime::dispatch($task['id']);
        }
    }
}
