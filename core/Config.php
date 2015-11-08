<?php

namespace Core;

/**
 * Class Config
 * Gère les configurations de l'application
 */
class Config
{

    /**
     * Tous les éléments de du fichier de config chargé
     * @var array
     */
    private static $items = [];

    /**
     * Charge un fichier de configuration
     * @param string $filepath
     * @return void
     */
    public static function load($filepath)
    {
        static::$items = include(dirname(__DIR__) . '/app/config/' . "$filepath.php");
    }

    /**
     * Cherche un élément dans les fichiers de config
     * @param string $key
     * @return string
     */
    public static function get($key = null)
    {
        $input = explode('.', $key);
        $filepath = $input[0];
        unset($input[0]);
        $key = implode('.', $input);

        static::load($filepath);

        if (!empty($key)) {
            return static::$items[$key];
        }

        return static::$items;
    }

}