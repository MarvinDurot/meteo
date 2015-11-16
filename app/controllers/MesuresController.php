<?php

namespace App\Controllers;
use Core\File\CSVFile;
use Core\File\FileException;
use Core\Table\TableException;

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
        // Récupération de la station
        $station = $this->stations->find($id);

        // Si aucune station trouvée
        if (empty($station)) $this->notFound();

        if (!empty($_POST)) {

            // Création d'une mesure
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

        // Affichage de la vue
        $this->render('mesures.create', compact('station', 'result'));
    }

    /**
     * Création de plusieurs relevés à partir d'un fichier CSV
     */
    public function upload()
    {
        if (!empty($_POST) && isset($_FILES['csv'])) {
            $result = true;

            try {
                // Récupération du fichier
                $csv = new CSVFile($_FILES['csv']);
                $station_name = explode('.', $csv->name)[0];

                // Parcours du CSV et création des relevés
                foreach ($csv->getIterator() as $station) {
                    if (empty($station)) continue;

                    try {
                        $result = $this->mesures->create([
                            'station' => $station_name,
                            'quand' => $station['quand'],
                            'temp1' => $station['temp1'],
                            'temp2' => $station['temp2'],
                            'pressure' => $station['pressure'],
                            'lux' => $station['lux'],
                            'hygro' => $station['hygro'],
                            'windSpeed' => $station['windSpeed'],
                            'windDir' => $station['windDir']
                        ]);
                    } catch(TableException $e) {
                        $result = false;
                        break;
                    }

                    if (!$result) break;
                }

            } catch(FileException $e) {
                $result = false;
            }
        }

        // Affichage de la vue
        $this->render('mesures.upload', compact('result'));
    }
}