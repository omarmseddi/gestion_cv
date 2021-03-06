<?php
// src/App/ApiBundle/Entity/RefreshToken.php

namespace App\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *  @ORM\Table(name="RefreshToken")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="token",
 *          column=@ORM\Column(
 *              name     = "token",
 *              length   = 191,
 *              unique   = true
 *          )
 *      )
 * })
 */
class RefreshToken extends BaseRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected $user;
}