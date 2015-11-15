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
        echo json_encode($this->Station->all('id', 'libelle'));
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
    public function releves($station)
    {
        $s = $this->Station->find($station);
        $mesures = $this->Mesure->where('station', $station, 5);
        array_walk($mesures, array($s, 'convert'));
        echo json_encode($mesures);
    }

    /**
     * Ajoute un relevé
     */
    public function add($station)
    {
        if (!empty($_POST)) {
            return $this->Mesure->create([
                'station' => $station,
                'quand' => date('Y-m-d G:i:s'),
                'temp1' => $_POST['temp1'],
                'temp2' => $_POST['temp2'],
                'pressure' => $_POST['pressure'],
                'lux' => $_POST['lux'],
                'hydro' => $_POST['hydro'],
                'windSpeed' => $_POST['windSpeed'],
                'windDir' => $_POST['windDir']
            ]);
        }
    }
}