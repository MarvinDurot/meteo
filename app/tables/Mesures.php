<?php

namespace App\Tables;
use Core\Table\Table;

/**
 * Class Mesures
 * @package App\Tables
 */
class Mesures extends Table
{
    protected $table = 'Mesures';
    protected $class = 'App\Models\Mesure';
    protected $key = ['station', 'quand'];
    protected $increment = false;
}