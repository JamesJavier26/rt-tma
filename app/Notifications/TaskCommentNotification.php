<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCommentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task, $comment)
    {
        $this->task = $task;
        $this->comment = $comment;
        $this->userName = $comment->user->name;
        $this->taskId = $task->id;
        $this->taskName = $task->name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {

        return [
            'message' => $this->task->name . ' - ' . $this->comment->comment,
            'link' => url('/tasks/' . $this->task->id), // Adjust the link as needed
            'user_name' => $this->comment->user->name,
            'task_id' => $this->task->id,
            'task_name' => $this->task->name,
            'comment' => $this->comment->comment,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'user_name' => $this->userName,
            'task_id' => $this->taskId,
            'task_name' => $this->taskName,
            'comment' => $this->comment->comment,
        ];
    }
}
