<?php

namespace Custura\Trane\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class TeamEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The team instance.
     *
     * @var \Custura\Trane\Models\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param  \Custura\Trane\Models\Team  $team
     * @return void
     */
    public function __construct($team)
    {
        $this->team = $team;
    }
}
