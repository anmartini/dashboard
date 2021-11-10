<?php

namespace App\Console\Components\Arpa;

use App\Services\Arpa\ArpaApi;
use Illuminate\Console\Command;
use App\Events\Arpa\MeteoFetched;

class FetchMeteo extends Command
{
    protected $signature = 'dashboard:fetch-arpa-meteo';

    protected $description = 'Fetch Arpa meteo';

    public function handle(ArpaApi $arpa)
    {
    	$dataOggi = $arpa->getGiorno('oggi')->getProvincia(config('services.arpa.provincia', 'BO'))->getZona(config('services.arpa.zona', 'P'));
        $dataDomani = $arpa->getGiorno('domani')->getProvincia(config('services.arpa.provincia', 'BO'))->getZona(config('services.arpa.zona', 'P'));
        $dataDopodomani = $arpa->getGiorno('dopodomani')->getProvincia(config('services.arpa.provincia', 'BO'))->getZona(config('services.arpa.zona', 'P'));

        $oggi = [
            'aggiornamento' => $arpa->getGiorno('oggi')->aggiornamento->diffForHumans(),
        	'dati' => $dataOggi->dati,
        	'mattina' => $dataOggi->getOrario('mattina'),
        	'pomeriggio' => $dataOggi->getOrario('pomeriggio'),
        	'sera_notte' => $dataOggi->getOrario('sera_notte'),
        ];

        $domani = [
            'aggiornamento' => $arpa->getGiorno('domani')->aggiornamento->diffForHumans(),
        	'dati' => $dataDomani->dati,
        	'mattina' => $dataDomani->getOrario('mattina'),
        	'pomeriggio' => $dataDomani->getOrario('pomeriggio'),
        	'sera_notte' => $dataDomani->getOrario('sera_notte'),
        ];

        $dopodomani = [
            'aggiornamento' => $arpa->getGiorno('dopodomani')->aggiornamento->diffForHumans(),
        	'dati' => $dataDopodomani->dati,
        	'mattina' => $dataDopodomani->getOrario('mattina'),
        	'pomeriggio' => $dataDopodomani->getOrario('pomeriggio'),
        	'sera_notte' => $dataDopodomani->getOrario('sera_notte'),
        ];

        event(new MeteoFetched($oggi, $domani, $dopodomani));
    }
}
