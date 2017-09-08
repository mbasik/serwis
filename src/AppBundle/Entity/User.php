<?php
/**
 * User entity.
 */
namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping\ClassMetadata;


/**
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="fos_user"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\UserRepository"
 * )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Classifieds.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection $classifieds
     *
     * @ORM\ManyToMany(
     *     targetEntity="Classified",
     *     mappedBy="users",
     * )
     */
    protected $classifieds;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }



    /**
     * Add classifieds
     *
     * @param \AppBundle\Entity\Classified $classifieds
     * @return User
     */
    public function addClassified(\AppBundle\Entity\Classified $classifieds)
    {
        $this->classifieds[] = $classifieds;

        return $this;
    }

    /**
     * Remove classifieds
     *
     * @param \AppBundle\Entity\Classified $classifieds
     */
    public function removeClassified(\AppBundle\Entity\Classified $classifieds)
    {
        $this->classifieds->removeElement($classifieds);
    }

    /**
     * Get classifieds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassifieds()
    {
        return $this->classifieds;
    }
}
