<?php

namespace App\Console\Components\Lumiere;

use Illuminate\Console\Command;
use App\Services\Lumiere\LumiereApi;
use App\Events\Lumiere\ProgrammazioneFetched;

class FetchProgrammazione extends Command
{
    protected $signature = 'dashboard:fetch-lumiere-programmazione';

    protected $description = 'Fetch programmazione Lumiere';

    public function handle(LumiereApi $lumiere)
    {
        event(new ProgrammazioneFetched($lumiere->getProssimeProiezioni()));
    }
}
