<?php
/**
 * User repository.
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use AppBundle\Entity\User;
/**
 * Class UserRepository.
 *
 * @package AppBundle\Repository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param $page
     * @return Pagerfanta
     */
    public function findAllPaginated($page)
    {
        $adapter = new DoctrineORMAdapter(
            $this->queryAll()
        );
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage('6'); // TODO: move to entity class!
        $pagerfanta->setCurrentPage($page);
        return $pagerfanta;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function queryAll()
    {
        return $this->_em->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:User', 'u');
    }

    /**
     * Save entity.
     *
     * @param User $user User entity
     */
    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user)
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

}
