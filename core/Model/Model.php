<?php

namespace Core\Model;

/**
 * Class Model
 * @package Core\Model
 * Représente un enregistrement d'une table
 */
class Model implements \JsonSerializable
{
    /**
     * Champs du JSON
     * @var array
     */
    protected $jsonnable = [];

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
        return array_filter($this->getFields(), function ($key) {
            return in_array($key, $this->jsonnable);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Convertit le modèle en chaine JSON
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this);
    }
}

?>
