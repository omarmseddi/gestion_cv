<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 11:18
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 *@ApiResource(attributes={
 *     "normalization_context"={"groups"={"read_cat"}},
 *     "denormalization_context"={"groups"={"write_cat"}}})
 */
class Categorie
{
    /**
     * @Groups({"write", "read" ,"write_cat", "read_cat"})
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Groups({"write", "read","write_cat", "read_cat"})
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @Groups({"read_cat"})
     * @ORM\OneToMany(targetEntity="CV", mappedBy="Categorie", cascade={"persist"})
     * @var CV[]
     */
    protected $CV;
    public function __construct()
    {
        $this->CV = new ArrayCollection();
    }
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