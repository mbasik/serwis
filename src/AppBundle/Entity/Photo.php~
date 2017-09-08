<?php
/**
 * Photo entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Photo.
 *
 * @package Entity
 *
 * @ORM\Table(
 *      name="photos",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="UQ_photos_1",
 *              columns={"photo"},
 *          ),
 *     },
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\PhotoRepository"
 * )
 * @UniqueEntity(
 *     groups={"photo-default"},
 *     fields={"photo"}
 * )
 */
class Photo
{
    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     */
    const NUM_ITEMS = 10;

    /**
     * Primary key.
     *
     * @var int $id
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
     * Title.
     *
     * @var string $title
     *
     * @ORM\Column(
     *     name="title",
     *     type="string",
     *     length=64,
     *     nullable=false,
     * )
     * @Assert\NotBlank(
     *     groups={"photo-default"},
     * )
     */
    protected $title;

    /**
     * Filename.
     *
     * @var string $photo
     *
     * @ORM\Column(
     *     name="photo",
     *     type="string",
     *     length=191,
     *     nullable=false,
     *     unique=true,
     * )
     * @Assert\NotBlank(
     *     groups={"photo-default"},
     * )
     * @Assert\Image(
     *     groups={"photo-default"},
     *     maxSize = "1024k",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/jpeg", "image/pjpeg"},
     * )
     */
    protected $photo;

    /**
     * @ORM\OneToMany(targetEntity="Classified", mappedBy="photo")
     */
    private $classified;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classified = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     * @return Photo
     */
    public function setName($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Add classified
     *
     * @param \AppBundle\Entity\Classified $classified
     * @return Photo
     */
    public function addClassified(\AppBundle\Entity\Classified $classified)
    {
        $this->classified[] = $classified;

        return $this;
    }

    /**
     * Remove classified
     *
     * @param \AppBundle\Entity\Classified $classified
     */
    public function removeClassified(\AppBundle\Entity\Classified $classified)
    {
        $this->classified->removeElement($classified);
    }

    /**
     * Get classified
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassified()
    {
        return $this->classified;
    }
}
