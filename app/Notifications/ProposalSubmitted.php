<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Proposal;
use App\Models\Project;

class ProposalSubmitted extends Notification
{
    use Queueable;

    public $proposal;
    public $project;
    public $developer;

    /**
     * Create a new notification instance.
     */
    public function __construct(Proposal $proposal, Project $project)
    {
        $this->proposal = $proposal;
        $this->project = $project;
        $this->developer = $proposal->user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Proposal Submitted for ' . $this->project->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new proposal has been submitted for your project: ' . $this->project->title)
            ->line('Developer: ' . $this->developer->name)
            ->line('Bid Amount: $' . number_format($this->proposal->bid_amount, 2))
            ->action('View Proposal', route('projects.proposals.index', $this->project))
            ->line('Thank you for using CodeConnect!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'developer_name' => $this->developer->name,
            'bid_amount' => $this->proposal->bid_amount,
            'message' => 'New proposal submitted for ' . $this->project->title . ' by ' . $this->developer->name
        ];
    }
}
