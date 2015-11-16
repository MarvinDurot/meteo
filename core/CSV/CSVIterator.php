<?php

namespace Core\CSV;

/**
 * Class CSVIterator
 * @package Core\CSV
 */
class CSVIterator extends \SPLFileObject
{
    /**
     * Booléen qui sert à indiquer si on
     * se trouve sur la première ligne du fichier
     * @var bool
     */
    protected $first_row = true;

    /**
     * Nom des colonnes
     * @var
     */
    protected $columns;

    /**
     * Constructeur
     * @param $filename
     * @param string $delimiter
     */
    public function __construct ($filename, $delimiter = ',')
    {
        parent::__construct($filename);
        $this->setFlags(\SPLFileObject::READ_CSV);
        $this->setCsvControl($delimiter);
    }

    /**
     * Redéfinition
     * @return array|bool
     */
    public function current()
    {
        /* Récupération du nom des colonnes

         * Note : le nom des colonnes est supposé
         * être sur la première ligne
         */
        if ($this->first_row) {
            $this->first_row = false;
            $this->columns = parent::current();
            $this->next();
        }

        $row_data = parent::current();

        // Arrêt à la fin du fichier
        if (!$this->valid()) {
            return false;
        }

        return array_combine($this->columns, $row_data);
    }
}