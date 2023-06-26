<?php

namespace App\Providers\Interal;

use App\Jobs\Internal\Sprints\IdentifyTagSprints;
use App\Models\Task;
use Illuminate\Support\ServiceProvider;

class IdentifyTagSprintsProvider extends ServiceProvider
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

    public static function identify(): void
    {
        $tasks = Task::where('tags', 'REGEXP', 'sp[0-9]')->get();
        foreach ($tasks as $task){
            IdentifyTagSprints::dispatch($task);
        }
    }
}
