<?php
// src/AppBundle/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\CV;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity
 *  * @ORM\Table(name="fos_user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *              name     = "username_canonical",
 *              length   = 191,
 *              unique   = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "email_canonical",
 *              length   = 191,
 *              unique   = true
 *          )
 *      )
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @Groups({"write", "read" })
     * @ORM\OneToMany(targetEntity="CV", mappedBy="creerPar", cascade={"persist","remove"})
     * @var CV[]
     */
    protected $CV;
    public function __construct()
    {
        parent::__construct();
        $this->CV = new ArrayCollection();
    }
}