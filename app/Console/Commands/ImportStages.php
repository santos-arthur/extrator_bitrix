<?php

namespace App\Console\Commands;

use App\Providers\Bitrix\StageProvider;
use Illuminate\Console\Command;

class ImportStages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Bitrix groups (Do not uses queues)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        StageProvider::import();
    }
}
