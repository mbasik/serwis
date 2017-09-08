<?php
/**
 * Tag entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="tags"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\TagRepository"
 * )
 * @UniqueEntity(
 *     groups={"tag-default"},
 *     fields={"name"}
 * )
 */
class Tag
{
    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     */
    const NUM_ITEMS = 5;

    /**
     * Primary key.
     *
     * @var integer $id
     *
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
     * Name.
     *
     * @var string $name
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=128,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank(
     *     groups={"tag-default"}
     * )
     * @Assert\Length(
     *     groups={"tag-default"},
     *     min="3",
     *     max="128",
     * )
     */
    protected $name;

    /**
    * Classifieds.
    *
    * @var \Doctrine\Common\Collections\ArrayCollection $classifieds
    *
    * @ORM\ManyToMany(
    *     targetEntity="Classified",
    *     mappedBy="tags",
    * )
    */
    protected $classifieds;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add classifieds
     *
     * @param \AppBundle\Entity\Classified $classifieds
     * @return Tag
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classifieds = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
