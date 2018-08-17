<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 09/08/2018
 * Time: 22:04
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class CvRepository extends EntityRepository
{
    public function findCvByPage($take,$skip,$ordre,$colonne,$search,$value)
    {
/*        return $this->getEntityManager()
            ->createQuery(
                "SELECT c FROM App:CV c WHERE :search LIKE :value  "
            )
            ->setParameter('search', $search)
        ->setParameter('value', $value)
            ->setMaxResults($take)
            ->setFirstResult($skip)
            //->addOrderBy($colonne, $value)
            ->getResult();*/
        $em=$this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $result = $qb->select('n')->from('App:CV', 'n')
            ->where( $qb->expr()->like('n.'.$search, $qb->expr()->literal('%' . $value . '%')) )
            ->orderBy('n.'.$colonne,$ordre)
            ->getQuery()
            ->setFirstResult($skip)
            ->setMaxResults($take)
        ->getResult();
        return $result;

    }
   public function findCvPageGroup($take,$skip,$ordre,$colonne,$search,$value,$group)
    {
        $em=$this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $result = $qb->select('n')->from('App:CV', 'n')
            ->orderBy('n.'.$group, $ordre)
            ->orderBy('n.'.$colonne,$ordre)
            ->getQuery()
            ->setFirstResult($skip)
            ->setMaxResults($take)
            ->getResult();
        return $result;
    }
    public function countItems()
    {
        $em =$this->getEntityManager();
        $qb=$em->createQueryBuilder();
        $result= $qb->select('count(c)')
            ->from('App:CV','c')
            ->getQuery()->getSingleScalarResult();
        return $result;
    }
        public function filterByCategorie($take,$skip,$ordre,$colonne,$value)
    {
        $em=$this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $result = $qb->select('cv')->from('App:CV', 'cv')->innerJoin('cv.categorie','ca','WITH','ca.id = cv.categorie')
            ->where( $qb->expr()->like('ca.nom', $qb->expr()->literal('%' . $value . '%')) )
            ->orderBy('cv.'.$colonne,$ordre)
            ->getQuery()
            ->setFirstResult($skip)
            ->setMaxResults($take)
            ->getResult();
        return $result;

    }
    public function filterByTechnologie($take,$skip,$ordre,$colonne,$value)
    {
/*        $em=$this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $result = $qb->select('cv')->from('App:CV', 'cv')->innerJoin('cv.id','ct','WITH','ct.cv_id = cv.id')
            ->innerJoin('ct.cv_id','t','WITH','ct.technologie_id = t.id')
            ->where( $qb->expr()->like('t.nom', $qb->expr()->literal('%' . $value . '%')) )
            ->orderBy('cv.'.$colonne,$ordre)
            ->getQuery()
            ->setFirstResult($skip)
            ->setMaxResults($take)
            ->getResult();
        return $result;*/
        $em = $this->getEntityManager();

        $connection= $em->getConnection();

        $sql="  select cv.id,cv.nom,cv.prenom,cv.id_sp,cv.type,cv.mission,cv.disponibilite,t.nom AS nomTech,ca.nom AS nomCat 
                from cv_technologie AS ct,categorie AS ca,cv,technologie AS t 
                where ct.cv_id = cv.id AND ct.technologie_id = t.id 
                AND cv.categorie_id = ca.id and t.nom LIKE  '%".$value."%' ORDER BY cv.".$colonne." ".$ordre." LIMIT ".$take." offset ".$skip." ";

        $statement = $connection ->prepare($sql);
        $statement->execute();
        $response = $statement->fetchAll();
        return $response;

    }


}