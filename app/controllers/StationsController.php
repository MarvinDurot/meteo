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
        // Récupération des stations
        $stations = $this->stations->all();

        // Si aucune station trouvée
        if (empty($stations)) $this->notFound();

        // Affichage de la vue
        $this->render('stations.index', compact('stations'));
    }

    /**
     * Affiche une station et ses 5 derniers relevés
     * @param $id
     */
    public function show($id)
    {
        // Récupération de la station
        $station = $this->stations->find($id);

        // Si aucune station trouvée
        if (empty($station)) $this->notFound();

        // Récupération des 5 derniers relevés de la station
        $releves  = $this->mesures->where('station', $id, 'ORDER BY quand DESC LIMIT 5');

        // Conversion des mesures
        array_walk($releves, array($station, 'convert'));

        // Affichage de la vue
        $this->render('stations.show', compact('station', 'releves'));
    }

}