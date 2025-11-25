<?php

namespace App\Notifications;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNewEnrollment extends Notification
{
    use Queueable;

    public $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function via($notifiable)
    {
        return ['database'];  // store in DB
    }

    public function toDatabase($notifiable)
    {
        // Make sure this returns an array, NOT a JSON string
        return [
            'type' => 'admin_new_enrollment',
            'user_name' => $this->enrollment->user->name,
            'course_name' => $this->enrollment->course->name,
            'enrollment_id' => $this->enrollment->id,
            'message' => "{$this->enrollment->user->name} applied for {$this->enrollment->course->name}.",
            'status' => 'pending',
        ];
    }
}
