<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.lastName', 'DESC');
    }
}