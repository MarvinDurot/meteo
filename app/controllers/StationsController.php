<?php

namespace App\Controllers;

/**
 * Class StationsController
 * @package App\Controllers
 */
class StationsController extends AppController
{
    /**
     * StationsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('App\Tables\Stations', 'stations');
        $this->loadTable('App\Tables\Mesures', 'mesures');
    }

    /**
     * Index
     */
    public function index()
    {
        $this->stations();
    }

    /**
     * Affiche toutes les stations
     */
    public function stations()
    {
        $stations = $this->stations->all();
        $this->render('stations.index', compact('stations'));
    }

    /**
     * Affiche une station et ses 5 derniers relevés
     * @param $id
     */
    public function show($id)
    {
        $station = $this->stations->find($id);
        $releves  = $this->mesures->where('station', $id, 'ORDER BY quand DESC LIMIT 5');
        array_walk($releves, array($station, 'convert'));
        $this->render('stations.show', compact('station', 'releves'));
    }

}