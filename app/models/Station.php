<?php

namespace App\Models;
use Core\Model\Model;

/**
 * Class Station
 * @package App\Models
 */
class Station extends Model
{
    /**
     * Table de conversion des mesures
     * @var array
     */
    public $conversions = [];

    /**
     * Convertit une mesure avec la fonction affine de la station
     * @param $mesure
     * @return void
     */
    public function convert($mesure)
    {
        // Pour chaque unité de la table de conversion
        foreach ($this->conversions as $type => $coeffs) {

            // Si le type de mesure existe
            if (!empty($mesure->$type)) {
                $res = $mesure->$type * $coeffs['a'] - $coeffs['b'];
                $mesure->$type = round($res, 0);
            }
        }
    }
}