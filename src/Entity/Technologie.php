<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 11:21
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;




/**
 *@ApiResource(attributes={
 *     "normalization_context"={"groups"={"read_tech"}},
 *     "denormalization_context"={"groups"={"write_tech"}}})
 * @ORM\Entity()
 */
class Technologie
{
    /**
     * @Groups({"write", "read","write_tech", "read_tech"})
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Groups({"write", "read","write_tech", "read_tech"})
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @Groups({"write", "read","write_tech", "read_tech"})
     * @ORM\Column(type="boolean")
     */
    protected $status;

    /**
     * @Groups({"read_cat", "read_tech"})
     * @ORM\ManyToMany(targetEntity="Technologie", mappedBy="CV", cascade={"persist"})
     * @var CV[]
     */
    protected $CV;

    public function __construct()
    {
        $this->CV = new ArrayCollection();
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