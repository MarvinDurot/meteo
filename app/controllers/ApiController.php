<?php

namespace App\Controllers;

class ApiController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadTable('App\Tables\Stations', 'stations');
        $this->loadTable('App\Tables\Mesures', 'mesures');
    }

    /**
     * Affiche toutes les stations
     */
    public function stations()
    {
        echo json_encode($this->stations->all('id', 'libelle'));
    }

    /**
     * Affiche une station
     * @param $id
     */
    public function station($id)
    {
        echo json_encode($this->stations->find($id));
    }

    /**
     * Affiche les 5 derniers relevés d'une station
     * @param $station
     */
    public function mesures($station)
    {
        $s = $this->stations->find($station);
        $mesures = $this->mesures->where('station', $station, 'ORDER BY quand DESC LIMIT 5');
        array_walk($mesures, array($s, 'convert'));
        echo json_encode($mesures);
    }

    /**
     * Insert un nouveau relevé
     */
    public function create()
    {
        if (!empty($_POST)) {
            return $this->mesures->create([
                'station' => $_POST['station'],
                'quand' => date('Y-m-d H:i:s', time()),
                'temp1' => $_POST['temp1'],
                'temp2' => $_POST['temp2'],
                'pressure' => $_POST['pressure'],
                'lux' => $_POST['lux'],
                'hygro' => $_POST['hygro'],
                'windSpeed' => $_POST['windSpeed'],
                'windDir' => $_POST['windDir']
            ]);
        }
    }
}