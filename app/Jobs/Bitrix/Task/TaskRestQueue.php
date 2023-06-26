<?php

namespace App\Jobs\Bitrix\Task;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TaskRestQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $tasksToImport;
    protected int $pageTasksToImport;
    protected int $group;
    /**
     * Create a new job instance.
     */
    public function __construct(int $total, int $group)
    {
        $this->tasksToImport = $total;
        $this->pageTasksToImport = 0;
        $this->group = $group;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        while ($this->tasksToImport > $this->pageTasksToImport * 50){
            ImportTasks::dispatch($this->pageTasksToImport, $this->group);
            $this->pageTasksToImport++;
        }
    }
}
