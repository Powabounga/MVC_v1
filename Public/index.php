<?php


// On définit la constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

use App\Autoloader;
use App\Core\Main;
use App\Models\AnnoncesModel;

//On importe l'autoloader
require_once ROOT.'/Autoloader.php';
Autoloader::register();

// On instancie Main (routeur)
$app = new Main();

// On démarre l'appication
$app->start();
?>