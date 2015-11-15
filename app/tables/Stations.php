<?php

namespace App\Tables;
use Core\Table\Table;

class Stations extends Table
{
    protected $table = 'Stations';
    protected $class = 'App\Models\Station';
    protected $key = ['id'];
    protected $increment = false;

    /**
     * Requête préparée
     * @var null
     */
    protected $stmtRelation = null;

    /**
     * Récupère une station avec sa table de conversion
     * @param string $id
     * @return mixed
     */
    public function find($id)
    {
        $station = parent::find($id);

        // Préparation de la requête
        if ($this->stmtRelation === null) {
            $sql = "SELECT mesure, a, b FROM Conversions WHERE station=?";
            $this->stmtRelation = $this->pdo->prepare($sql);
        }

        // Éxécution de la requête et récupération des résultats
        $this->stmtRelation->execute([$id]);
        $conversions = $this->stmtRelation->fetchAll(\PDO::FETCH_ASSOC);

        // Groupement par type de mesure
        foreach ($conversions as $conversion) {
            $station->conversions[$conversion['mesure']] = [
                'a' => $conversion['a'],
                'b' => $conversion['b']
            ];
        }

        return $station;
    }
}