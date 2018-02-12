<?php

namespace App\Console;

use Illuminate\Console\Command;

class UpdateDashboard extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle()
    {
        $this->call('dashboard:fetch-calendar-events');
        $this->call('dashboard:send-heartbeat');
        $this->call('dashboard:fetch-current-track');
        $this->call('dashboard:fetch-tasks');
        $this->call('dashboard:fetch-arpa-meteo');
        $this->call('dashboard:fetch-lumiere-programmazione');
    }
}
