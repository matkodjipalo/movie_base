<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class MovieRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC');
    }
}