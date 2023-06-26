<?php

namespace App\Jobs\Internal\Sprints;

use App\Models\TagSprints;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function PHPUnit\Framework\matchesRegularExpression;
use function PHPUnit\Framework\throwException;

class IdentifyTagSprints implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Task $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tags = explode(';', $this->task->tags);
        if (!is_array($tags))
            return;
        foreach ($tags as $tag) {
            $replacedTag = str_replace('sp', '', $tag);
            if (!is_numeric($replacedTag) || !preg_match('/sp([0-9])/', $tag))
                continue;
            TagSprints::updateOrCreate([
                'task_id' => $this->task->id,
                'sprint_number' =>  $replacedTag,
                'sprint_tag' => $tag
            ]);
        }
    }
}
