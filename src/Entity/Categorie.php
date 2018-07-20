<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 11:18
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table(name="Categorie")
 */
class Categorie
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
     * @ORM\OneToMany(targetEntity="CV", mappedBy="Categorie")
     * @var CV[]
     */
    protected $CV;

    /**
     * @return CV[]
     */
    public function getCV(): array
    {
        return $this->CV;
    }


    /**
     * @param CV $CV
     */
    public function setCV(CV $CV): void
    {
        $this->CV = $CV;
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