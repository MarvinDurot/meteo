<?php

namespace Core\File;

/**
 * Class File
 * @package Core\Form
 */
class File
{
    /**
     * Fichier
     * @var
     */
    protected $file;

    /**
     * Extensions valides
     * @var array
     */
    protected $ext = [
        'jpg',
        'png',
        'gif',
        'csv',
        'xls',
        'doc',
        'txt',
        'pdf',
        'xml'
    ];

    /**
     * Constructeur
     * @param $file
     * @throws FileException
     */
    public function __construct($file)
    {
        if ($this->validate($file))
            $this->file = $file;
        else
            throw new FileException('Invalid upload!');
    }

    /**
     * Valide un fichier uploadé
     * @param $file
     * @return bool
     */
    protected function validate($file)
    {
        if ($file['error'] > 0) return false;

        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        return in_array($file_ext, $this->ext);
    }

    /**
     * Getter
     * @param $name
     * @return mixed
     * @throws FileException
     */
    public function __get($name)
    {
        if (!isset($this->file[$name])) {
            throw new FileException('Invalid file property!');
        }

        return $this->file[$name];
    }
}