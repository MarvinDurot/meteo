<?php

namespace App\Controllers;

class ApiController extends AppController
{
    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('App\Tables\Stations', 'stations');
        $this->loadTable('App\Tables\Mesures', 'mesures');
    }

    /**
     * Affiche la documentation de l'API
     */
    public function doc()
    {
        $this->render('api.documentation');
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
        // Récupération de la station
        $s = $this->stations->find($station);

        // Récupération des 5 dernières mesures
        $mesures = $this->mesures->where('station', $station, 'ORDER BY quand DESC LIMIT 5');

        // Conversion des mesures
        array_walk($mesures, array($s, 'convert'));
        echo json_encode($mesures);
    }

    /**
     * Insertion d'un nouveau relevé
     */
    public function create()
    {
        if (!empty($_POST)) {
            return $this->mesures->create([
                'station' => $_POST['station'],
                'quand' => $_POST['quand'],
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