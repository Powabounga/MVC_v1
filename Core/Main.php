<?php

namespace App\Core;
use App\Controllers\MainController;

/**
 * Routeur principal
 */
class Main{
    public function start(){

        // On démarre la session 
        session_start();
        
        // http://127.0.0.1/controleur/methode/param
        // http://127.0.0.1/annonces/details/...
        // http://127.0.0.1/index.php?p=annonces/details/...

        // On retire le 'trailing slash' éventuel de l'URL
        // On récuère l'URL
        $uri = $_SERVER['REQUEST_URI'];

        // On vérifie que uri n'est pas vide et se termine par un /
        if(!empty($uri) && $uri != '/' && $uri[-1] === '/'){
            // On enlève le /
            $uri = substr($uri, 0, -1);

            // On envoie un code de redirection permanente 
            http_response_code(301);

            // On redirige vers l'URL sans le / 
            header('Location: '.$uri);
            exit;
        };

        // On gère les paramètres d'URL
        // p=controleur/methode/paramètres
        // On sépare les paramètres dans un tableau
        $params = explode('/', $_GET['p']);

        // Si au moins 1 paramètre existe
        if($params[0] != ""){
            // On récupère le nom du controller à instancier
            // On met une majuscule en première lettre, on ajoute le namespace complet avant et on ajoute "Controller" après
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

            // On instancie le controller
            $controller = new $controller;

            // On récupère le deuxième paramètre d'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if(method_exists($controller, $action)){
                // S'il reste des paramètres, on les passe à la méthode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            }else{
                http_response_code(404);
                echo "La page recherché n'existe pas";
            }

        }else{
            // On n'a pas de paramètres 
            // On instancie le controlleur par défaut
            $controller = new MainController;

            // On appelle la méthode index
            $controller->index();
        }
    }
}