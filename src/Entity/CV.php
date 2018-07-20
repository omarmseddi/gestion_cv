<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 10:54
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="CV")
 */
class CV
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @ORM\Column(type="string")
     */
    protected $prenom;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="CV")
     * @var Categorie
     */
    protected $categorie;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $mission;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $disponibilite;

    /**
     * @ORM\ManyToMany(targetEntity="Technologie")
     * @var Technologie[]
     */
    protected $technologies;

    /**
     * @ORM\Column(type="integer")
     */
    protected $id_fichier;

    /**
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @ORM\Column(type="date")
     */
    protected $date_modification;

    /**
     * @ORM\Column(type="date")
     */
    protected $date_creation;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creer_par;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $id_categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return mixed
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @param mixed $mission
     */
    public function setMission($mission): void
    {
        $this->mission = $mission;
    }

    /**
     * @return mixed
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * @param mixed $disponibilite
     */
    public function setDisponibilite($disponibilite): void
    {
        $this->disponibilite = $disponibilite;
    }

    /**
     * @return mixed
     */
    public function getIdFichier()
    {
        return $this->id_fichier;
    }

    /**
     * @param mixed $id_fichier
     */
    public function setIdFichier($id_fichier): void
    {
        $this->id_fichier = $id_fichier;
    }

    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->date_modification;
    }

    /**
     * @param mixed $date_modification
     */
    public function setDateModification($date_modification): void
    {
        $this->date_modification = $date_modification;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return mixed
     */
    public function getCreerPar()
    {
        return $this->creer_par;
    }

    /**
     * @param mixed $creer_par
     */
    public function setCreerPar($creer_par): void
    {
        $this->creer_par = $creer_par;
    }

    /**
     * @return mixed
     */
    public function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * @param mixed $technologies
     */
    public function setTechnologies($technologies): void
    {
        $this->technologies = $technologies;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }


}
