<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 11:21
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table(name="Technologie")
 */
class Technologie
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
     * @ORM\Column(type="boolean")
     */
    protected $status;

    /**
     * @ORM\ManyToMany(targetEntity="CV")
     * @var CV[]
     */
    protected $CV;


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

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return CV[]
     */
    public function getCV(): array
    {
        return $this->CV;
    }

    /**
     * @param CV[] $CV
     */
    public function setCV(array $CV): void
    {
        $this->CV = $CV;
    }


}