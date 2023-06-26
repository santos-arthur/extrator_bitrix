<?php

namespace App\Console\Commands;

use App\Providers\Bitrix\UserProvider;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-users';

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
        UserProvider::import();
    }
}
