<?php

namespace App\Console\Commands;

use App\Models\Bitrix;
use App\Models\Stage;
use App\Providers\Bitrix\TaskProvider;
use Illuminate\Console\Command;

class ImportTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Bitrix tasks (Uses queues)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        TaskProvider::import();
    }
}
