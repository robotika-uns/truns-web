<?php

namespace App\Notifications;

use App\Recruit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecruitNotification extends Notification
{
    use Queueable;

    public $recruit;
    public $slug;

    public function __construct(Recruit $recruit, array $slug = [])
    {
        $this->recruit = $recruit;
        $this->slug = $slug;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'id'        => $this->recruit->id,
            'pesan'     => "recruit_{$this->recruit->status}",
            'slug'      => $this->slug
        ];
    }
}
