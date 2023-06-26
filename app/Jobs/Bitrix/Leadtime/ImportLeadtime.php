<?php

namespace App\Jobs\Bitrix\Leadtime;

use App\Models\Bitrix;
use App\Models\Leadtimes;
use App\Models\Stage;
use App\Models\Status;
use App\Models\Task;
use DateTimeImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportLeadtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $taskId;
    protected int $taskGroup;
    /**
     * Create a new job instance.
     */
    public function __construct(int $taskId, int $taskGroup)
    {
        $this->taskId = $taskId;
        $this->taskGroup = $taskGroup;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $history = Bitrix::call('tasks.task.history.list', [
            'taskId' => $this->taskId,
            'filter' => [ 'field' => [
                'NEW',
                'STAGE'
            ] ]
        ]);
        $firstGroupStage = Stage::where('group_id', $this->taskGroup)->where('default', 1)->first();
        if($firstGroupStage)
            $firstGroupStage = $firstGroupStage->toArray()['id'];
        else
            $firstGroupStage = 0;
        $lastStage = 0;
        foreach ($history['result']['list'] as $item){
            $createdDate = DateTimeImmutable::createFromFormat('d/m/Y H:i:s', $item['createdDate'])->modify('-3 hours')->format('Y-m-d\\TH:i:sP');

            switch($item['field']){
                case 'NEW':
                    Leadtimes::updateOrCreate([
                        'task_id' => $this->taskId,
                        'stage_id' => $firstGroupStage
                    ], [
                        'entered_at' => $createdDate
                    ]);
                    $lastStage = $firstGroupStage;
                    break;
                case 'STAGE':
                    Leadtimes::updateOrCreate([
                        'task_id' => $this->taskId,
                        'stage_id' => $lastStage
                    ], [
                        'left_at' => $createdDate
                    ]);

                    $currentStage = Stage::where('group_id', $this->taskGroup)->where('title', $item['value']['to'])->first();
                    if($currentStage)
                        $currentStage = $currentStage->toArray()['id'];
                    else
                        $currentStage = 0;
                    Leadtimes::updateOrCreate([
                        'task_id' => $this->taskId,
                        'stage_id' => $currentStage
                    ], [
                        'entered_at' => $createdDate
                    ]);

                    $lastStage = $currentStage;
                    break;
            }
        }

        $task = Task::find($this->taskId);

        $arrayOpenTaskStatus = [];
        $arrayStatus = Status::where('open', true)->get()->toArray();

        foreach ($arrayStatus as $status){
            $arrayOpenTaskStatus[] = $status['id'];
        }
        if(!in_array($task->status_id, $arrayOpenTaskStatus)){
            $task->import_leadtimes = false;
            $task->save();
        }
    }
}
