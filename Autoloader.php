<?php

namespace App;

class Autoloader
{
    static function register()
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    static function autoload($class)
    {
        // On récupère dans $class la totalité du namespace de la classe concernée
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);

        // On remplace les \ par des /
        $fichier = __DIR__ . '/' . $class . '.php';

        // On vérifie si le fichier existe
        if (file_exists($fichier)) {
            require_once $fichier;
        }
    }
}