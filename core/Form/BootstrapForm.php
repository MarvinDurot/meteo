<?php

/**
 * Class BootstrapForm
 * Construit un formulaire Bootstrap avec des données
 */
class BootstrapForm extends Form
{
    /**
     * Entoure du html avec une balise
     * @param $html : code html
     * @return string : code html
     */
    protected function surround($html)
    {
        return '<div class="form-group">' . $html . '</div>';
    }

    /**
     * Retourne un champ de type input
     * @param $name : nom du champ
     * @return string : code html
     */
    public function input($name)
    {
        return $this->surround(
            '<input type="text" class="form-control" name="' . $name . '" value="' . $this->getValue($name) . '" required>'
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
            '<button type="submit" name="' . $name . '" class="btn btn-primary pull-right">Sauvegarder</button>'
        );
    }
}