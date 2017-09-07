<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Photo;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class PhotoRepository extends EntityRepository
{
// ...
    /**
     * Save entity.
     *
     * @param Photo $photo Photo entity
     */
    public function save(Photo $photo)
    {
        $this->_em->persist($photo);
        $this->_em->flush();
    }
// ...
}