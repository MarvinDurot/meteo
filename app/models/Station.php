<?php

namespace App\Models;

use Core\Model\Model;

class Station extends Model
{
    protected $jsonnable = [
        'id',
        'libellé',
        'latitude',
        'longitude',
        'altitude'
    ];

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
            if ($mesure->$type !== null) {
                $mesure->$type =
                    round($mesure->$type * $coeffs['a'] - $coeffs['b'], 0);
            }
        }
    }
}