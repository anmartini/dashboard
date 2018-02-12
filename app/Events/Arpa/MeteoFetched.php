<?php

namespace App\Events\Arpa;

use App\Events\DashboardEvent;

class MeteoFetched extends DashboardEvent
{
    public $oggi;
    public $domani;

    public function __construct($oggi, $domani)
    {
        $this->oggi = $oggi;
        $this->domani = $domani;
    }
}
