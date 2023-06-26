<?php

namespace App\Jobs\Bitrix\Task;

use App\Models\Bitrix;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $page;
    protected int $group;
    /**
     * Create a new job instance.
     */
    public function __construct(int $page, int $group)
    {
        $this->page = $page;
        $this->group = $group;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $tasks = Bitrix::call('tasks.task.list', [
            'filter' => [
                'GROUP_ID' => $this->group
            ],
            'select' => [
                'ID',
                'PARENT_ID',
                'TITLE',
                'GROUP_ID',
                'STAGE_ID',
                'CREATED_BY',
                'CREATED_DATE',
                'RESPONSIBLE_ID',
                'CLOSED_BY',
                'CLOSED_DATE',
                'TIME_ESTIMATE',
                'TIME_SPENT_IN_LOGS',
                'AUDITORS',
                'ACCOMPLICES',
                'STATUS',
                'TAGS',
            ],
            'start' => $this->page * 50
        ]);

        foreach ($tasks['result']['tasks'] as $task){
            $id = $task['id'];
            $parentId = $task['parentId'] ?? null;
            $title = $task['title'] ?? null;
            $groupId = $task['groupId'] ?? null;
            $stageId = $task['stageId'] ?? null;
            $status = $task['status'] ?? null;
            $createdBy = $task['createdBy'] ?? null;
            $createdDate = $task['createdDate'] ?? null;
            $responsibleId = $task['responsibleId'] ?? null;
            $closedBy = $task['closedBy'] ?? null;
            $closedDate = $task['closedDate'] ?? null;
            $timeEstimate = $task['timeEstimate'] ?? null;
            $timeSpent = $task['timeSpentInLogs'] ?? null;
            $auditors = $task['auditors'] ?? null;
            $accomplices = $task['accomplices'] ?? null;
            $tags = $task['tags'] ?? null;
            $taskTags = null;
            if(is_array($tags)){
                foreach ($tags as $tag){
                    $taskTags[] = $tag['title'];
                }
            }
            Task::updateOrCreate(['id' => $id], [
                'title' => $title,
                'parent_id' => $parentId,
                'group_id' => $groupId,
                'stage_id' => $stageId,
                'status_id' => $status,
                'created_by' => $createdBy,
                'created_date' => $createdDate,
                'responsible_id' => $responsibleId,
                'closed_by' => $closedBy,
                'closed_date' => $closedDate,
                'time_estimate' => $timeEstimate,
                'time_spent' => $timeSpent,
                'auditors' => is_array($auditors) ? implode(';', $auditors) : $auditors,
                'accomplices' => is_array($accomplices) ? implode(';', $accomplices) : $accomplices,
                'tags' => is_array($taskTags) ? implode(';', $taskTags) : $taskTags,
            ]);
        }
    }
}
