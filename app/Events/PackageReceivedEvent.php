<?php

namespace App\Events;

use App\Models\Address;
use App\Models\Package;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PackageReceivedEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $package;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Package $package)
    {
        $this->user = $user;
        $this->package = $package;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
