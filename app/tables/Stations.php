<?php

namespace App\Tables;
use Core\Table\Table;

class StationsTable extends Table
{
    protected $table = 'Stations';
    protected $class = 'App\Models\Station';
    protected $key = ['station'];
    protected $increment = false;
}