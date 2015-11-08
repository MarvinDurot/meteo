<?php

namespace App\Tables;
use Core\Table\Table;

class MesuresTable extends Table
{
    protected $table = 'Mesures';
    protected $class = 'App\Models\Mesure';
    protected $key = ['station', 'quand'];
    protected $increment = false;

    protected $stmtLastFive = null;

    /**
     * Récupère les 5 derniers relevés d'une station
     * @param $station
     * @return array
     */
    public function lastFive($station)
    {
        // Préparation de la requête
        if ($this->stmtLastFive === null) {
            $sql = "SELECT  FROM $this->table JOIN Conversions JOIN ON  WHERE station=? LIMIT 5";
            $this->stmtLastFive = $this->pdo->prepare($sql);
        }

        // Éxécution de la requête et récupération des résultats
        $this->stmtLastFive->execute([$station]);
        $this->stmtLastFive->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        return $this->stmtLastFive->fetchAll();
    }
}