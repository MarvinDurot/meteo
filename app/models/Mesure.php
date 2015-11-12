<?php

namespace App\Models;
use Core\Model\Model;

class Mesure extends Model
{
    protected $jsonnable = ['station', 'quand', 'temp1', 'temp2', 'pressure'];
}