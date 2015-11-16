<?php

namespace Core\File;
use Core\CSV\CSVIterator;

/**
 * Class CSVFile
 * @package Core\Form
 */
class CSVFile extends File
{
    /**
     * Extensions valides
     * @var array
     */
    protected $ext = ['csv'];

    /**
     * Retourne l'itérateur de CSV associé
     * @return CSVIterator
     */
    public function getIterator()
    {
        return new CSVIterator($this->file['tmp_name']);
    }
}