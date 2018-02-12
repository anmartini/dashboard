<?php

namespace App\Events\Lumiere;

use App\Events\DashboardEvent;
use Illuminate\Support\Collection;

class ProgrammazioneFetched extends DashboardEvent
{
    public $programmazione;

    public function __construct(Collection $programmazione)
    {
        $this->programmazione = $programmazione;
    }
}
