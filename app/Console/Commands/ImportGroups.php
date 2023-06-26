<?php

namespace App\Console\Commands;

use App\Providers\Bitrix\GroupProvider;
use Illuminate\Console\Command;

class ImportGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Bitrix groups (Uses queues)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GroupProvider::import();
    }
}
