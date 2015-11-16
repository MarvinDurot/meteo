<?php

namespace App\Controllers;

/**
 * Class MesuresController
 * @package App\Controllers
 */
class MesuresController extends AppController
{
    /**
     * MesuresController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('App\Tables\Mesures', 'mesures');
        $this->loadTable('App\Tables\Stations', 'stations');
    }

    /**
     * Création d'un nouveau relevé
     * @param string $id
     */
    public function create($id)
    {
        $station = $this->stations->find($id);

        if (!empty($_POST)) {
            $result = $this->mesures->create([
                'station' => $id,
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

        $this->render('mesures.create', compact('station', 'result'));
    }

    /**
     * Création de plusieurs relevés à partir d'un fichier XML
     */
    public function upload()
    {
        if (!empty($_POST)) {
            $result = true;

            $upload = (object)$_FILES['xml'];
            $xml = $upload->error ? NULL : simplexml_load_file($upload->tmp_name);

            // Création des relevés
            foreach ($xml as $station) {
                $result = $this->mesures->create($station);
                if (!$result) break;
            }
        }

        $this->render('mesures.upload', compact('result'));
    }

}