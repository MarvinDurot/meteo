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
     * Champs du modèle
     * @var array
     */
    protected $fields = [];

    /**
     * Constructeur
     * @param $fields
     */
    public function __construct($fields) {
        $this->fields = $fields;
    }

    /**
     * Retourne tous les champs du modèle
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Implémentation de JsonSerializable
     * @return string
     */
    public function jsonSerialize()
    {
        // Filtrage des éléments vides
        return array_filter($this->fields);
    }

    /**
     * Rédéfinition ToString
     * @return string
     */
    public function __toString() {
        return implode("\t", $this->fields);
    }

    /**
     * Getter
     * @param $field
     * @return mixed
     * @throws ModelException
     */
    public function __get($field)
    {
        if (array_key_exists($field, $this->fields))
            return $this->fields[$field];

        throw new ModelException("Invalid field name $field");
    }

    /**
     * Setter
     * @param $field
     * @param $value
     * @throws ModelException
     */
    public function __set($field, $value)
    {
        if (! array_key_exists($field, $this->fields))
            throw new ModelException("Invalid field name $field");

        $this->fields[$field] = $value;
    }

    /**
     * Rédéfinition isset
     * @param $field
     * @return bool
     */
    public function __isset($field)
    {
        return array_key_exists($field, $this->fields);
    }
}
?>
