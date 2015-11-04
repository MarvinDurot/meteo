<?php

/**
 * Class Form
 * Construit un formulaire simple avec des données
 */
class Form
{
    // Données du formulaire
    protected $data;
    // Balise qui entoure les champs input
    public $surround = 'p';

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Entoure du html avec une balise
     * @param $html : code html
     * @return string : code html
     */
    protected function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    /**
     * Retourne la valeur d'un champ en fonction de son index
     * @param $index : index du champ
     * @return mixed
     */
    protected function getValue($index)
    {
        return $this->data[$index];
    }

    /**
     * Retourne un champ de type input
     * @param $name : nom du champ
     * @return string : code html
     */
    public function input($name)
    {
        return $this->surround(
            '<input type="text" name="' . $name . '" value="' . $this->getValue($name) . '"/>'
        );
    }

    /**
     * Retourne un champ caché
     * @param $name : nom du champ
     * @return string : code html
     */
    public function hidden($name)
    {
        return '<input type="hidden" name="' . $name . '" value="' . $this->getValue($name) . '"/>';
    }

    /**
     * Retourne un formulaire de soumission de fichier
     * @param $name : nom du champ
     * @param string $label : libellé
     * @return string : code html
     */
    public function upload($name, $label = '')
    {
        return $this->surround(
            '<label for="' . $name . '">' . $label . '</label><input type="file" name="' . $name . '"/>'
        );
    }

    /**
     * Retourne un bouton de soumission de formulaire
     * @param string $name : nom du champ
     * @return string
     */
    public function submit($name = 'submit')
    {
        return $this->surround(
            '<button type="submit" name="' . $name . '">Sauvegarder</button>'
        );
    }
}