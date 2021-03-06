<?php

namespace Taseera\BackendBundle\Repository;

/**
 * TRegionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TRegionRepository extends \Doctrine\ORM\EntityRepository
{
    //get Regions of Qatar
    public function getRegionQatar()
    {
        return $this->createQueryBuilder('t')
            ->where('t.tCountry = :id')
            ->setParameter('id', 1)
            ->getQuery()
            ->getResult();
    }
}
