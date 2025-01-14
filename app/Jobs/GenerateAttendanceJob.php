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

    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $attendanceGenerator = AttendanceGenerator::find($this->id);
        $attendanceGenerator->generate();
    }

    public function failed(\Exception $exception)
    {
        $attendanceGenerator = AttendanceGenerator::find($this->id);
        $attendanceGenerator->error_message = $exception->getMessage();
        $attendanceGenerator->save();
    }
}
