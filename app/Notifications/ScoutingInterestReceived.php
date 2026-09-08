<?php

namespace App\Notifications;

use App\Models\ScoutingInterest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ScoutingInterestReceived extends Notification
{
    use Queueable;

    public function __construct(
        public ScoutingInterest $scoutingInterest
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $this->scoutingInterest->loadMissing(['scout.scoutProfile']);

        $scoutName = $this->scoutingInterest->scout->name;
        $organization = $this->scoutingInterest->scout->scoutProfile?->organization;

        return [
            'scouting_interest_id' => $this->scoutingInterest->id,
            'scout_id' => $this->scoutingInterest->scout_id,
            'scout_name' => $scoutName,
            'organization' => $organization,
            'title' => $organization 
                ? "New Scouting Interest from {$organization} ({$scoutName})"
                : "New Scouting Interest from {$scoutName}",
            'message' => $this->scoutingInterest->message 
                ?: "A scout has expressed official interest in your football profile.",
            'url' => route('scouting.interests.show', $this->scoutingInterest),
        ];
    }
}
