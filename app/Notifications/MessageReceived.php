<?php

namespace App\Notifications;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MessageReceived extends Notification
{
    use Queueable;

    public function __construct(
        public Conversation $conversation,
        public Message $message
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        $sender = $this->message->sender; // ensure loaded in controller

        return [
            'type' => 'message',
            'message' => sprintf('New message from %s: %s', $sender?->name ?? 'Someone', str($this->message->body)->limit(80)),
            'conversation_id' => $this->conversation->id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $sender?->name,
            'link' => route('inbox.show', $this->conversation),
        ];
    }
}
