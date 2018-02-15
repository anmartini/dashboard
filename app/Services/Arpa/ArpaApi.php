<?php

namespace App\Services\Arpa;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ArpaApi
{
    private $data;

    public function __construct()
    {
        $client = new Client();
        try {
            $this->data = json_decode($client->get('https://www.arpae.it/smr/external/bollettino/bollettino_previ_provinciali.php?t=json')->getBody());
        } catch (GuzzleException $e) {
            $this->data = null;
        }
    }

    public function getGiorno(string $giorno) : ArpaGiorno
    {
        try {
            $data = $this->data->{$giorno};
        } catch (\Exception $e) {
            return null;
        }

        return new ArpaGiorno($data);
    }

    public function getTendenza() : ArpaTendenza
    {
        return new ArpaTendenza($this->data->tendenza);
    }
}

class ArpaData
{
    protected $data;
    public $aggiornamento;

    public function __construct($data)
    {
        $this->data = $data->xml;
        $this->aggiornamento = Carbon::createFromTimestamp($data->xml->{'@attributes'}->timestamp);
    }
}

class ArpaGiorno extends ArpaData
{
    public function getProvincia(string $provincia)
    {
        try {
            $data = $this->data->provinciale->{$provincia};
        } catch (\Exception $e) {
            return null;
        }

        return new ArpaProvincia($data, $this->getDati($provincia));
    }

    protected function getDati($provincia)
    {
        switch ($provincia) {
            case 'PC':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 13),
                    'C' => new ArpaDati($this->data->dati, 1),
                    'R' => new ArpaDati($this->data->dati, 1),
                ];
            case 'PR':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 12),
                    'C' => new ArpaDati($this->data->dati, 14),
                    'R' => new ArpaDati($this->data->dati, 14),
                ];
            case 'RE':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 15),
                    'C' => new ArpaDati($this->data->dati, 14),
                    'R' => new ArpaDati($this->data->dati, 14),
                ];
            case 'MO':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 11),
                    'C' => new ArpaDati($this->data->dati, 2),
                    'R' => new ArpaDati($this->data->dati, 2),
                ];
            case 'BO':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 10),
                    'C' => new ArpaDati($this->data->dati, 2),
                    'R' => new ArpaDati($this->data->dati, 2),
                ];
            case 'FE':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 9),
                    'C' => new ArpaDati($this->data->dati, 8),
                    'M' => new ArpaDati(),
                ];
            case 'RA':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 6),
                    'C' => new ArpaDati($this->data->dati, 7),
                    'R' => new ArpaDati($this->data->dati, 3),
                    'M' => new ArpaDati(),
                ];
            case 'FC':
                return (object) [
                    'P' => new ArpaDati($this->data->dati, 6),
                    'C' => new ArpaDati($this->data->dati, 5),
                    'R' => new ArpaDati($this->data->dati, 4),
                    'M' => new ArpaDati(),
                ];
            case 'RN':
                return (object) [
                    'P' => new ArpaDati(),
                    'C' => new ArpaDati($this->data->dati, 5),
                    'R' => new ArpaDati($this->data->dati, 4),
                    'M' => new ArpaDati(),
                ];
            default:
                return null;
        }
    }
}

class ArpaDati
{
    public $temperatura_minima = null;
    public $temperatura_massima = null;
    public $precipitazioni = null;
    public $vento_massimo = null;

    public function __construct($data = null, int $id = null)
    {
        if ($data && $id) {
            $this->temperatura_minima = intval($data->temperatura_minima->{'t' . $id}->{'@attributes'}->dato);
            $this->temperatura_massima = intval($data->temperatura_massima->{'T' . $id}->{'@attributes'}->dato);
            $this->precipitazioni = $data->precipitazioni->{'P' . $id}->{'@attributes'}->dato === '0' ? false : $data->precipitazioni->{'P' . $id}->{'@attributes'}->dato;
            $this->vento_massimo = intval($data->vento_massimo->{'V' . $id}->{'@attributes'}->dato);
        }
    }
}

class ArpaProvincia
{
    protected $meteo;
    protected $dati;
    public $previsione;

    public function __construct($meteo, $dati)
    {
        $this->meteo = $meteo;
        $this->dati = $dati;
        $this->previsione = $meteo->testo_previsione;
    }

    public function getZona(string $zona)
    {
        try {
            $dati = $this->dati->{$zona};

            $meteo = (object) [
                'mattina' => $this->meteo->mattina->{$zona}->{'@attributes'},
                'pomeriggio' => $this->meteo->pomeriggio->{$zona}->{'@attributes'},
                'sera_notte' => $this->meteo->sera_notte->{$zona}->{'@attributes'},
            ];
        } catch (\Exception $e) {
            return null;
        }

        return new ArpaZona($meteo, $dati);
    }
}

class ArpaZona
{
    protected $meteo;
    public $dati;

    public function __construct($meteo, $dati)
    {
        $this->meteo = $meteo;
        $this->dati = $dati;
    }

    public function getOrario(string $orario)
    {
        try {
            $meteo = $this->meteo->{$orario};
        } catch (\Exception $e) {
            return null;
        }

        return new ArpaOrario($meteo);
    }
}

class ArpaOrario
{
    public $previsione;
    public $icona;

    public function __construct($data)
    {
        $this->previsione = trim($data->it);
        $this->icona = '/images/arpa-meteo/' . $data->icona . $data->icona2 . '.svg';
    }
}

class ArpaTendenza extends ArpaData
{
    public $previsione;

    public function __construct($data)
    {
        $this->previsione = trim(ucfirst($data->testo));

        parent::__construct($data);
    }

    public function getGiorno(int $giorno)
    {
        try {
            $data = $this->data->{'giorno' . $giorno}->{'@attributes'};
        } catch (\Exception $e) {
            return null;
        }

        return new ArpaGiornoTendenza($data);
    }
}

class ArpaGiornoTendenza
{
    public $temperatura;
    public $icona_temperatura;
    public $meteo;
    public $icona_meteo;

    public function __construct($data)
    {
        $this->temperatura = trim($data->tt_it);
        $this->icona_temperatura = $data->tt;
        $this->meteo = trim($data->tm_it);
        $this->icona_meteo = $data->tm;
    }
}
