<?php

namespace App\Models;


use App\Core\Db;

class Model extends Db{
    // Table pour la base de données
    protected $table;
    
    // Instance de Db
    private $db;

    public function findAll(){
        $query = $this->requete('SELECT * FROM '. $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteres){
        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau

        foreach($criteres as $champ => $valeur){
            // SELECT * FROM annonces WHERE ID = ?
            //bindValue(1, valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
            
        }
        // On transforme le tabeau "champs" en une chaine de caratères
        $liste_champs = implode(' AND ', $champs);

        //On éxecute la requete
        return $this->requete("SELECT * FROM {$this->table} WHERE $liste_champs", $valeurs)->fetchAll();
    }

    public function find(int $id){
        return $this->requete("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
    }

    public function create(){
        $champs = [];
        $inter = [];
        $valeurs = []; 

        // On boucle pour éclater le tableau

        foreach($this as $champ => $valeur){
            // INSERT INTO annonces (id,prenom,nom,email,password) VALUES (?, ?, ?, ?, ?)
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
            
        }
        // On transforme le tabeau "champs" en une chaine de caratères
        $liste_champs = implode(' , ', $champs);
        $liste_inter = implode(', ', $inter);


        //On éxecute la requete
        return $this->requete('INSERT INTO '.$this->table.' ('. $liste_champs.')VALUES('.$liste_inter.')', $valeurs);
    }

    public function update(){
        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau

        foreach($this as $champ => $valeur){
            // UPDATE annonces SET id = ?, prenom = ?, nom = ?, email = ?, password = ? WHERE id = ? (?, ?, ?, ?, ?)
            if($valeur != null && $champ != 'db' && $champ != 'table'){
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
            
        }
        $valeurs[] = $this->id;

        // On transforme le tabeau "champs" en une chaine de caratères
        $liste_champs = implode(' , ', $champs);

        //On éxecute la requete
        return $this->requete('UPDATE '.$this->table.' SET '. $liste_champs.' WHERE id = ?', $valeurs);
    }

    public function delete(int $id){
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    protected function requete(string $sql, array $attributs = null){
        // On récupère 'instance de Db
        $this->db = Db::getInstance();
        
        // On vérifie si on a des attrbuts
        if($attributs !== null){
            // Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        }else{
            // Requête simple
            return $this->db->query($sql);
        }
    }

    public function hydrate($donnees){
        foreach($donnees as $key => $value){
            // On récupère le nom du setter correspondant à la clé 
            // prenom -> setPrenom
            $setter = 'set' .ucfirst($key);
            //On vérifie si le setter existe 
            if(method_exists($this, $setter)){
                //On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }
}