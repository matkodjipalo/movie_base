<?php

namespace AppBundle\Repository;


use AppBundle\Entity\CastAndCrew;
use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    /**
     * @param Movie $movie
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createAlphabeticalQueryBuilder(Movie $movie)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin(
                CastAndCrew::class,
                'cnc',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'p.id = cnc.person'
            )
            ->where('cnc.movie <> :movie')
            ->orWhere('cnc.person IS NULL')
            ->setParameter('movie', $movie)
            ->orderBy('p.lastName', 'ASC');
    }
}