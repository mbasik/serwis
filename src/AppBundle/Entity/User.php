<?php
/**
 * User entity.
 */
namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="fos_user"
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
     * @ORM\OneToMany(targetEntity="Classified", mappedBy="user")
     */
    private $classifieds;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->classifieds = new ArrayCollection();
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
