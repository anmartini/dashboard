<?php

namespace App\Events\Arpa;

use App\Events\DashboardEvent;

class MeteoFetched extends DashboardEvent
{
    public $oggi;
    public $domani;
    public $dopodomani;

    public function __construct($oggi, $domani, $dopodomani)
    {
        $this->oggi = $oggi;
        $this->domani = $domani;
        $this->dopodomani = $dopodomani;
    }
}
