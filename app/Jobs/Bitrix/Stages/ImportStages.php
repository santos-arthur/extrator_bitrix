<?php

namespace App\Jobs\Bitrix\Stages;

use App\Models\Bitrix;
use App\Models\Stage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportStages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $group;
    /**
     * Create a new job instance.
     */
    public function __construct(int $group)
    {
        $this->group = $group;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $stages = Bitrix::call('task.stages.get',[
            'entityId' => $this->group,
            'select' => [
                'ID',
                'TITLE',
                'SORT',
                'COLOR',
                'SYSTEM_TYPE'
            ]
        ]);
        foreach ($stages['result'] as $stage){
            $id = $stage['ID'];
            $title = $stage['TITLE'];
            $sort = $stage['SORT'];
            $color = $stage['COLOR'];
            $default = $stage['SYSTEM_TYPE'] == 'NEW';

            Stage::updateOrCreate(['id' => $id],[
                'title' => $title,
                'sort' => $sort,
                'color' => $color,
                'group_id' => $this->group,
                'default' => $default
            ]);
        }
    }
}
