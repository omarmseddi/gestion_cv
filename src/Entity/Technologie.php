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
use App\Entity\CV;
/**
 *@ApiResource(attributes={
 *                        "normalization_context"={"groups"={"read_tech"}},
 *                        "denormalization_context"={"groups"={"write_tech"}}
 *                        },
 *              collectionOperations={
 *                      "get" ,
 *                       "post",
 *                      "special"={"route_name"="get_techno_by_status"},
 *                       "delete"
 *              })
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="nom",
 *          column=@ORM\Column(
 *              name     = "nom",
 *              length   = 191,
 *              unique   = true
 *          )
 *      )
 * })
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
     * @Groups({"write", "read","write_tech", "read_tech","read_cat"})
     * @ORM\Column(type="string")
     */
    protected $nom;
    /**
     * @Groups({"write", "read","write_tech", "read_tech","read_cat"})
     * @ORM\Column(type="boolean", options={"default"= true},nullable=true)
     */
    protected $status;
    /**
     * @Groups({"read_tech"})
     * @ORM\ManyToMany(targetEntity="CV", mappedBy="technologies", cascade={"persist"})
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
     * @return mixed
     */
    public function getCV()
    {
        return $this->CV;
    }
    /**
     * @param mixed $CV
     */
    public function setCV(array $CV): void
    {
        $this->CV = $CV;
    }
    public function __toString(){
        return (string) $this->nom;
    }
}