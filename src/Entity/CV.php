<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 10:54
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Categorie;
use App\Entity\Technologie;
use App\Controller\CVController;
/**
 *  @ApiResource(attributes={
 *                      "normalization_context"={"groups"={"read"}},
 *                      "denormalization_context"={"groups"={"write"}},
 *                      "force_eager"=false
 *              },
 *              collectionOperations={
 *                      "get" ,
 *                      "special"={"route_name"="post_cv"}
 *              },
 *              itemOperations={
 *                      "get",
 *                      "special"={"route_name"="put_cv"},
 *                      "delete"
 *              }
 *
 * )
 * @ORM\Entity()
 * @ORM\Table(name="CV")
 */
class CV
{
    /**
     * @Groups({"write", "read","read_tech", "read_cat"})
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Groups({"write", "read","read_tech", "read_cat"})
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @Groups({"write", "read","read_tech", "read_cat"})
     * @ORM\Column(type="string")
     */
    protected $prenom;

    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $idSp;

    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\Column(type="date")
     */
    protected $dateModification;

    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\Column(type="date")
     */
    protected $dateCreation;

    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="CV", cascade={"persist","remove"})
     * @var User (nullable=true)
     */
    protected $creerPar;


    /**
     * @Groups({"write", "read","read_tech"})
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="CV", cascade={"persist","remove"})
     * @var Categorie (nullable=true)
     */
    protected $categorie;



    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\Column(type="boolean")
     */
    protected $mission;

    /**
     * @Groups({"write", "read" ,"read_tech", "read_cat"})
     * @ORM\Column(type="boolean")
     */
    protected $disponibilite;

    /**
     * @Groups({"write", "read" , "read_cat"})
     * @ORM\ManyToMany(targetEntity="Technologie", inversedBy="CV" , cascade={"persist"}) 
     * @var Technologie[] (nullable=true)
     */
    protected $technologies;


    /**
     *  @Groups({"write"})
     * @var Technologie[] (nullable=true)
     */
    protected $addTechnologies;

    public function __construct() {
       // $this->technologies = new ArrayCollection();
        $this->dateCreation=new \DateTime();
        $this->dateModification=new \DateTime();

    }

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
     * @param mixed $categorie
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
    public function getIdSp()
    {
        return $this->idSp;
    }

    /**
     * @param mixed $idSp
     */
    public function setIdSp($idSp): void
    {
        $this->idSp = $idSp;
    }

    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param mixed $dateModification
     */
    public function setDateModification($dateModification): void
    {
        $this->dateModification = $dateModification;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getCreerPar()
    {
        return $this->creerPar;
    }

    /**
     * @param mixed $creerPar
     */
    public function setCreerPar($creerPar): void
    {
        $this->creerPar = $creerPar;
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
    public function getAddTechnologies()
    {
        return $this->addTechnologies;
    }

    /**
     * @param mixed $addTechnologies
     */
    public function setAddTechnologies( $addTechnologies): void
    {
        $this->addTechnologies = $addTechnologies;
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
