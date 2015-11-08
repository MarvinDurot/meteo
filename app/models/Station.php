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

    public function convert($mesure)
    {
        $fields = $mesure->getFields();
        foreach($fields as $key => $value)
        {

        }
    }
}