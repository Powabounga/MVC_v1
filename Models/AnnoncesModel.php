<?php
namespace App\Models;

/**
 * Modèle pour la table "annonces"
 */
class AnnoncesModel extends Model
{
    protected $id;

    protected $titre;

    protected $description;

    protected $created_at;

    protected $actif;

    protected $users_id;
    
    public function __construct()
    {
        $this->table = 'annonces';
    }

    /**
     * Obtenir la valeur de id
     */ 
    public function getId():int
    {
        return $this->id;
    }

    /**
     * Définir la valeur de id
     *
     * @return  self
     */ 
    public function setId(int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Obtenir la valeur de titre
     */ 
    public function getTitre():string
    {
        return $this->titre;
    }

    /**
     * Définir la valeur de titre
     *
     * @return  self
     */ 
    public function setTitre(string $titre):self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Obtenir la valeur de description
     */ 
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * Définir la valeur de description
     *
     * @return  self
     */ 
    public function setDescription(string $description):self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Obtenir la valeur de created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Définir la valeur de created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at):self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Obtenir la valeur de actif
     */ 
    public function getActif():int
    {
        return $this->actif;
    }

    /**
     * Définir la valeur de actif
     *
     * @return  self
     */ 
    public function setActif(int $actif):self
    {
        $this->actif = $actif;

        return $this;
    }
    
    /**
     * Get the value of users_id
     */ 
    public function getUsers_id():int
    {
        return $this->users_id;
    }

    /**
     * Set the value of users_id
     *
     * @return  self
     */ 
    public function setUsers_id(int $users_id)
    {
        $this->users_id = $users_id;

        return $this;
    }
}