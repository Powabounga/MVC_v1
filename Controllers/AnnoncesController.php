<?php 

namespace App\Controllers;

use App\Core\Form;
use App\Models\AnnoncesModel;

class AnnoncesController extends Controller{
    /**
     * Cette méthode affichera une page listant toutes les annonces de la base de données
     * @return void 
     */
    public function index(){
        // On instancie le modèle correspondant à la table 'annonces'
        $annoncesModel = new AnnoncesModel;

        // On va chercher toutes les annonces actives
        $annonces = $annoncesModel->findBy(['actif' => 1]);

        // On génère la vue
        $this->render('annonces/index', compact('annonces'));
    }

    /**
     * Affiche une annonce
     *
     * @param int $id Id de l'annonce
     * @return void
     */
    public function detail(int $id){
        // On instancie le modèle 
        $model = new AnnoncesModel;

        // On va chercher une annonce
        $annonce = $model->find($id);

        // On envoie à la vue
        $this->render('annonces/detail', compact('annonce'));
    }

    /**
     * Créer une annonce
     *
     * @return void
     */
    public function ajouter(){
        // On vérifie si la session contient les informations d'un utilisateur
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){
            // L'utilisateur est connecté 
            // On vérifie si le formulaire est complet
            if(Form::validate($_POST, ['titre', 'description'])){
                // Le formulaire est complet
                // On se protège des failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // On instancie notre modèle
                $annonce = new AnnoncesModel;

                // On hydrate
                $annonce->setTitre($titre)
                    ->setDescription($description)
                    ->setActif(1)
                    ->setUsers_id($_SESSION['user']['id']);

                // On enregistre
                $annonce->create();
                
                // On redirige
                $_SESSION['message'] = "Votre annonce a été enregistré avec succès !";
                header('Location: /annonces');
                exit;
            }else{
                // Le formulaire est incomplet
                $_SESSION['erreur'] = !empty($_POST) ? "Le formulaire est incomplet" : "";
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';

            }

            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('titre', 'Titre de l\'annonce :')
                ->ajoutInput('text', 'titre', [
                    'id' => 'titre', 
                    'class' => 'form-control', 
                    'valule' => $titre])
                ->ajoutLabelFor('description', 'Description')
                ->ajoutTextarea('description', '', ['class' => 'form-control'])
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
                ->finForm();
            ;

            $this->render('annonces/ajouter', ['ajoutAnnonceForm' => $form->create()]);


        }else{
            $_SESSION['erreur'] = "Vous devez vous connecter pour ajouter une annonce";
            header('Location: /users/login');
            exit;
        }

    }
    
    /**
     * Modifier une annonce
     *
     * @param int $id Id de l'annonce
     * @return void
     */
    public function modifier(int $id){
        // On vérifie si la session contient les informations d'un utilisateur
        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])){
            // On va vérifier si l'annonce existe dans la base
            // On instancie notre modèle
            $annoncesModel = new AnnoncesModel;

            // On cherche l'annonce avec l'id $id
            $annonce = $annoncesModel->find($id);

            // Si l'annonce n'existe pas, on retourne à la liste des annonces
            if(!$annonce){
                http_response_code(404);
                $_SESSION['erreur'] = "L'annonce recherchée n'existe pas";
                header('Location: /annonces');
                exit;
            }

            // On vérifie si l'utilisateur est prorpiétaire de l'annonce ou admin
            if($annonce->users_id !== $_SESSION['user']['id']){
                if (!in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
                    $_SESSION['erreur'] = "Vous n'êtes pas propriétaire de cette annonce";
                    http_response_code(404);
                    header('Location: /');
                    exit;
                }
            }

            // On traite le formulaire
            if(Form::validate($_POST, ['titre', 'description'])){
                // On se protège contre les failles XSS
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // On stocke l'annonce
                $annonceModif = new AnnoncesModel;

                // On hydrate
                $annonceModif->setId($annonce->id)
                    ->setTitre($titre)
                    ->setDescription($description);

                // On met à jour l'annonce
                $annonceModif->update();

                // On redirige
                $_SESSION['message'] = "Votre annonce a été modifié avec succès !";
                header('Location: /annonces');
                exit;

            }

            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('titre', 'Titre de l\'annonce :')
                ->ajoutInput('text', 'titre', ['class' => 'form-control', 'value' => $annonce->titre])
                ->ajoutLabelFor('description', 'Description')
                ->ajoutTextarea('description', $annonce->description, ['class' => 'form-control'])
                ->ajoutBouton('Valider', ['class' => 'btn btn-primary'])
                ->finForm();
            
            $this->render('annonces/modifier', ['modifierAnnonceForm' => $form->create()]);

        }else{
            // L'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez vous connecter pour ajouter une annonce";
            header('Location: /users/login');
            exit;
        }
    }
}

?>