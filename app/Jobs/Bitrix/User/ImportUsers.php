<?php

namespace App\Jobs\Bitrix\User;

use App\Models\Bitrix;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $page;
    /**
     * Create a new job instance.
     */
    public function __construct(int $page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = Bitrix::call('user.get', [
            'start' => $this->page * 50
        ]);

        foreach ($users['result'] as $user){
            $id = $user['ID'];
            $name = $user['NAME'] ?? '';
            $name .= !empty($user['SECOND_NAME']) ? ' ' . $user['SECOND_NAME'] : '' ;
            $name .= !empty($user['LAST_NAME']) ? ' ' . $user['LAST_NAME'] : '' ;
            $email = $user['EMAIL'] ?? '';
            $active = $user['ACTIVE'] ?? false;

            User::updateOrCreate([
                'id' => $id
            ],[
                'name' => $name,
                'email' => $email,
                'active' => $active
            ]);
        }
    }
}
