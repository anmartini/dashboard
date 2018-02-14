<?php

namespace App\Services\Lumiere;

use Log;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LumiereApi
{
    public $programmazione;

    public function __construct()
    {
        $programmazione = Cache::get('lumiere-programmazione');

        if (!$programmazione) {
            $data = simplexml_load_file('http://www.cinetecadibologna.it/rss/oggi', 'SimpleXMLElement', LIBXML_NOCDATA)->channel->item;

            $programmazione = collect();
            foreach ($data as $item) {
                $programmazione->push(new LumiereProiezione($item));
            }

            $grouped = $programmazione->groupBy('titolo');

            $programmazione = collect();
            foreach ($grouped as $item) {
                $programmazione->push(new LumiereFilm($item->first(), $item->pluck('orario')));
            }

            $scadenza = Carbon::now()->endOfDay();

            Log::info('Lumiere messo in cache!', ['scadenza' => $scadenza]);

            Cache::put('lumiere-programmazione', $programmazione, $scadenza);
        }

        $this->programmazione = $programmazione;
    }

    public function getProssimeProiezioni() : Collection
    {
        $proiezioni = collect();
        $now = Carbon::now();

        foreach ($this->programmazione as $film) {
            $orari = $film->proiezioni->filter(function($item, $key) use ($now) {
                return $item->gt($now);
            });

            if ($orari->count() > 0)
                $proiezioni->push(new LumiereFilm($film, $orari));
        }

        return $proiezioni->sortBy(function($item, $key) {
            return $item->proiezioni->first();
        });
    }
}

class LumiereProiezione
{
    public $titolo;
    public $descrizione;
    public $orario;
    public $immagine;
    
    function __construct($data)
    {
        $this->titolo = (string) $data->title;
        $this->descrizione = (string) $data->description;
        $this->orario = new Carbon((string) $data->pubDate);
        $this->immagine = (string) $data->children('http://search.yahoo.com/mrss/')->content->thumbnail->attributes()->url;
    }
}

class LumiereFilm
{
    public $titolo;
    public $descrizione;
    public $immagine;
    public $proiezioni;
    
    function __construct($data, Collection $orari)
    {
        $this->titolo = $data->titolo;
        $this->descrizione = $data->descrizione;
        $this->immagine = $data->immagine;
        $this->proiezioni = $orari;
    }
}
