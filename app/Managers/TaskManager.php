<?php

namespace App\Managers;

use App\Models\Task;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\ProcessJobs;

class TaskManager 
{
    use DispatchesJobs;

    private const STATUS_FINISHED = 'finished';

    public function __construct()
    {
    }

    public function dispatchTask(): int
    {
        $job = new ProcessJobs();

        $this->dispatch($job);

        return $job->getJobStatusId();
    }

    public function getTask(int $id): Task
    {
        return Task::find($id);
    }

    public function getNextAvailableTask(): Task
    {
        return Task::where('status', self::STATUS_FINISHED)->orderBy('finished_at', 'DESC')->first();
    }

}