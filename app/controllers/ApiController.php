<?php

namespace App\Controllers;

class ApiController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('App\Tables\Stations', 'Station');
        $this->loadModel('App\Tables\Mesures', 'Mesure');
    }

    /**
     * Affiche toutes les stations
     */
    public function stations()
    {
        echo json_encode($this->Station->all('id', 'libellé'));
    }

    /**
     * Affiche une station
     * @param $id
     */
    public function station($id)
    {
        echo json_encode($this->Station->find($id));
    }

    /**
     * Affiche les 5 derniers relevés d'une station
     * @param $station
     */
    public function releves($station = null)
    {
        $s = $this->Station->find($station);
        $mesures = $this->Mesure->where('station', $station, 5);
        array_walk($mesures, array($s, 'convert'));
        echo json_encode($mesures);
    }

    /**
     * Ajoute un relevé
     */
    public function add()
    {

    }
}