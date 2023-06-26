<?php

namespace App\Providers\Bitrix;

use App\Jobs\Bitrix\Group\GroupRestQueue;
use App\Models\Bitrix;
use Illuminate\Support\ServiceProvider;

class GroupProvider extends ServiceProvider
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
        $groups = Bitrix::call('sonet_group.get', [
            'select' => [
                'ID'
            ]]);
        GroupRestQueue::dispatch($groups['total']);
    }
}
