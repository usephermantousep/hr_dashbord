<?php

namespace App\Jobs;

use App\Models\AttendanceGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateAttendanceJob implements ShouldQueue
{
    use Queueable;

    public $id;
    public $generatorId;

    /**
     * Create a new job instance.
     */
    public function __construct($id, $generatorId)
    {
        $this->id = $id;
        $this->generatorId = $generatorId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $attendanceGenerator = AttendanceGenerator::find($this->id);
        $attendanceGenerator->generate($this->generatorId);
    }

    public function failed(\Exception $exception)
    {
        $attendanceGenerator = AttendanceGenerator::find($this->id);
        $attendanceGenerator->error_message = $exception->getMessage();
        $attendanceGenerator->save();
    }
}
