<?php

namespace App\Providers\Bitrix;

use App\Jobs\Bitrix\User\CreateRestQueue;
use App\Jobs\Bitrix\User\UserRestQueue;
use App\Models\Bitrix;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
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

    /**
     * Import Users
     */
    public static function import(): void
    {
        $users = Bitrix::call('user.get', [
            'filter' => [
                'USER_TYPE' => ['employee', 'extranet']
                ]
        ]);
        UserRestQueue::dispatch($users['total']);
    }
}
