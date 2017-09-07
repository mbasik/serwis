<?php
/**
 * Publisher entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Publisher.
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="publishers"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\PublisherRepository"
 * )
 * @UniqueEntity(
 *     groups={"publisher-default"},
 *     fields={"name"}
 * )
 */
class Publisher
{
    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     */
    const NUM_ITEMS = 8;

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
     *     groups={"author-default"}
     * )
     * @Assert\Length(
     *     groups={"author-default"},
     *     min="3",
     *     max="128",
     * )
     */
    protected $name;

    /**
     * Email.
     *
     * @var string $email
     *
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     length=128,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank(
     *     groups={"email-default"}
     * )
     * @Assert\Length(
     *     groups={"email-default"},
     *     min="3",
     *     max="128",
     * )
     */
    protected $email;

    /**
     * Phone number.
     *
     * @var integer $phone_number
     *
     * @ORM\Column(
     *     name="phone_number",
     *     type="integer",
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank(
     *     groups={"phone_number-default"}
     * )
     */
    protected $phone_number;

    /**
     * @ORM\OneToMany(targetEntity="Classified", mappedBy="publisher")
     */
    private $classified;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->classified = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Author
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
     * Set phone_number
     *
     * @param integer $phone_number
     * @return Publisher
     */
    public function setPhone_number($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * Get phone_number
     *
     * @return integer
     */
    public function getPhone_number()
    {
        return $this->phone_number;
    }

    /**
     * Add classifieds
     *
     * @param \AppBundle\Entity\Classified $classifieds
     * @return Publisher
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
    public function removeClassifieds(\AppBundle\Entity\Classified $classifieds)
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
     * Set phone_number
     *
     * @param integer $phoneNumber
     * @return Publisher
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phone_number
     *
     * @return integer 
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
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

    /**
     * Set email
     *
     * @param string $email
     * @return Publisher
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}
