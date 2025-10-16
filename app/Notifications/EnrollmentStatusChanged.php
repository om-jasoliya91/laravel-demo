<?php

namespace App\Notifications;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EnrollmentStatusChanged extends Notification
{
    use Queueable;

    public $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_name' => $this->enrollment->course->name,
            'status' => $this->enrollment->status,
            'message' => "Your enrollment for {$this->enrollment->course->name} was {$this->enrollment->status}.",
        ];
    }
}
