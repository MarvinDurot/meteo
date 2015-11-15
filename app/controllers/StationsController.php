<?php

namespace App\Controllers;

class StationsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('App\Tables\Stations', 'Station');
        $this->loadModel('App\Tables\Mesures', 'Mesure');
    }

    // Index
    public function index()
    {
        $this->stations();
    }

    // Affiche les stations
    public function stations()
    {
        $stations = $this->Station->all();
        $this->render('stations.index', compact('stations'));
    }

    // Affiche une station
    public function show($id)
    {
        $station = $this->Station->find($id);
        $releves  = $this->Mesure->where('station', $id, 5);
        array_walk($releves, array($station, 'convert'));
        $this->render('stations.show', compact('station', 'releves'));
    }

}