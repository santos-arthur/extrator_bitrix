<?php

namespace App\Jobs\Bitrix\Group;

use App\Models\Bitrix;
use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportGroups implements ShouldQueue
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
        $groups = Bitrix::call('sonet_group.get', [
            'select' => [
                'ID',
                'NAME'
            ],
            'start' => $this->page * 50
        ]);

        foreach ($groups['result'] as $group){
            $id = $group['ID'];
            $name = $group['NAME'] ?? '';

            Group::updateOrCreate([
                'id' => $id
            ],[
                'name' => $name
            ]);
        }
    }
}
