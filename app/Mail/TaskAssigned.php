<?php

// app/Mail/TaskAssigned.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;
use App\Models\Employee;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task, Employee $employee)
    {
        $this->task = $task;
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.tasks.assigned')
                    ->with([
                        'task' => $this->task,
                        'employee' => $this->employee,
                    ]);
    }
}





