<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityRepository;

class CastAndCrewRepository extends EntityRepository
{
    public function findPersonIdsForMovie(Movie $movie)
    {
        return $this->createQueryBuilder('cnc')
            ->select('cnc.id')
            ->where('movie', $movie->getId());
    }
}