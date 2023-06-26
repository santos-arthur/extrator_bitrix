<?php

namespace App\Console\Commands;

use App\Jobs\Bitrix\Leadtime\ImportLeadtime;
use App\Models\Bitrix;
use App\Models\Leadtimes;
use App\Models\Stage;
use App\Models\Task;
use DateTimeImmutable;
use Illuminate\Console\Command;

class ImportLeadtimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-leadtimes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Bitrix leadtimes (Uses queues)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('import_leadtimes', 1)->get()->toArray();
        foreach ($tasks as $task){
            ImportLeadtime::dispatch($task['id'], $task['group_id']);
        }
    }
}
