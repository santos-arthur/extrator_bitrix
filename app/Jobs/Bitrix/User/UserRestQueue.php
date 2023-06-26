<?php

namespace App\Jobs\Bitrix\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRestQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $usersToImport;
    protected int $pageUsersToImport;
    /**
     * Create a new job instance.
     */
    public function __construct(int $total)
    {
        $this->usersToImport = $total;
        $this->pageUsersToImport = 0;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        while ($this->usersToImport > $this->pageUsersToImport * 50){
            ImportUsers::dispatch($this->pageUsersToImport);
            $this->pageUsersToImport++;
        }
    }
}
