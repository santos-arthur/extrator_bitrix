<?php

namespace App\Console\Commands;

use App\Providers\Interal\IdentifyTagSprintsProvider;
use Illuminate\Console\Command;

class IdentifyTagSprints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:identify-sprints';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        IdentifyTagSprintsProvider::identify();
    }
}
