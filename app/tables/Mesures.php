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
     * R�cup�re les 5 derniers relev�s d'une station
     * @param $station
     * @return array
     */
    public function lastFive($station)
    {
        // Pr�paration de la requ�te
        if ($this->stmtLastFive === null) {
            $sql = "SELECT  FROM $this->table JOIN Conversions JOIN ON  WHERE station=? LIMIT 5";
            $this->stmtLastFive = $this->pdo->prepare($sql);
        }

        // �x�cution de la requ�te et r�cup�ration des r�sultats
        $this->stmtLastFive->execute([$station]);
        $this->stmtLastFive->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        return $this->stmtLastFive->fetchAll();
    }
}