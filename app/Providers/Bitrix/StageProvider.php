<?php

namespace App\Providers\Bitrix;

use App\Jobs\Bitrix\Stages\ImportStages;
use App\Models\Bitrix;
use App\Models\Stage;
use Illuminate\Support\ServiceProvider;

class StageProvider extends ServiceProvider
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
            ImportStages::dispatch($group);
        }
    }
}
