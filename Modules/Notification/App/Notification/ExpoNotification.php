<?php

namespace Modules\Notification\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class ExpoNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $data;
    
    public function __construct($title, $body, $data = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return [ExpoChannel::class];
    }

    public function toExpoPush($notifiable)
    {
        $message = ExpoMessage::create()
            ->title($this->title)
            ->body($this->body)
            ->enableSound();

        if (!empty($this->data)) {
            $message->setJsonData($this->data);
        }

        return $message;
    }
}