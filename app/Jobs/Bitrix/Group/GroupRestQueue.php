<?php

namespace App\Jobs\Bitrix\Group;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GroupRestQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $groupsToImport;
    protected int $pageGroupsToImport;

    /**
     * Create a new job instance.
     */
    public function __construct(int $total)
    {
        $this->groupsToImport = $total;
        $this->pageGroupsToImport = 0;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        while ($this->groupsToImport > $this->pageGroupsToImport * 50){
            ImportGroups::dispatch($this->pageGroupsToImport);
            $this->pageGroupsToImport++;
        }
    }
}
