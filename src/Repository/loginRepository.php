<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 09/08/2018
 * Time: 22:04
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class loginRepository extends EntityRepository
{

    public function getLogger($id)
    {
        $em =$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $result=$qb->select('username')
            ->from('App:User','c')
            ->where('c.id = '.$id )
            ->getQuery();
        return $result;
    }
}