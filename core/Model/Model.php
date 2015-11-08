<?php

namespace Core\Model;

/**
 * Class Model
 * @package Core\Model
 * Représente un enregistrement d'une table
 */
abstract class Model implements \JsonSerializable
{
    /**
     * Champs du JSON
     * @var array
     */
    protected $jsonnable = [];

    /**
     * Champs éditables
     * @var array
     */
    protected $fillable = [];

    /**
     * Setter
     * @param $field
     * @param $value
     */
    public function __set($field, $value)
    {
        if (in_array($field, $this->fillable))
            $this->$field = $value;
    }

    /**
     * Retourne les champs du modèle
     * @return array
     */
    public function getFields()
    {
        return get_object_vars($this);
    }

    /**
     * Implémentation de JsonSerializable
     * @return string
     */
    public function jsonSerialize()
    {
        $data = [];
        $fields = get_object_vars($this);

        foreach($this->jsonnable as $f) {
            $data[] = $fields[$f];
        }

        return $data;
    }

    /**
     * Retourne la représentation JSON du modèle
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this);
    }
}

?>
