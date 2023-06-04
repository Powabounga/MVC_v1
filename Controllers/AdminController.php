<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;

class AdminController extends Controller{
    public function index(){

        // On vérifie si on est admin
        if($this->isAdmin()){
            $this->render('admin/index', [], 'admin');
        }
    }

    /**
     * Affiche la liste des annonces sous forme de tableau
     */
    public function annonces(){
        if($this->isAdmin()){
            $annoncesModel = new AnnoncesModel;

            $annonces = $annoncesModel->findAll();

            $this->render('admin/annonces', compact('annonces'), 'admin');
        }
    }

    /**
     * Supprime une annonce si on est admin
     * @param int $id
     * @return void
     */
    public function supprimeAnnonce(int $id){
        if($this->isAdmin()){
            $annonce = new AnnoncesModel;

            $annonce->delete($id);
            $_SESSION['message'] = "L'annonce a bien été supprimée";
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    /**
     * Verifie si on est admin 
     * @return true 
     */
    private function isAdmin(){
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos roles
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])){
            // On est admin
            return true;
        }else{
            // On est pas admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location: /');
            exit;
        }
    }

    /**
     * Active ou désactive une annonce
     * @param int $id
     * @return void
     */
    public function activeAnnonce(int $id){
        if($this->isAdmin()){
            $annoncesModel = new AnnoncesModel;

            $annonceArray = $annoncesModel->find($id);

            if($annonceArray){
                $annonce = $annoncesModel->hydrate($annonceArray);

                $annonce->setActif($annonce->getActif() ? 0 : 1);

                $annonce->update();

                $_SESSION['message'] = "L'annonce a bien été activer/désativer";
                header('Location: /');
                exit;
            }
        }
    }
}