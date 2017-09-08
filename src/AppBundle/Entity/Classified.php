<?php
/**
 * Classified entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Classified.
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(
 *     name="classifieds"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\ClassifiedRepository"
 * )
 * @UniqueEntity(
 *     groups={"classified-default"},
 *     fields={"name",
 *              "content",
 *              "createdAt",
 * }
 * )
 */
class Classified
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
     * Content.
     *
     * @var string $content
     *
     * @ORM\Column(
     *     name="content",
     *     type="string",
     *     length=1000,
     *     nullable=false,
     * )
     */
    protected $content;

    /**
     * Price.
     *
     * @var string $price
     *
     * @ORM\Column(
     *     name="price",
     *     type="integer",
     *     length=10,
     *     nullable=false,
     * )
     */
    protected $price;

    /**
     * User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="classifieds")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
        protected $user;

     /**
     * Created at.
     *
     * @var \DateTime $createdAt
     *
     * @ORM\Column(
     *     name="created_at",
     *     type="datetime",
     *     nullable=false,
     * )
     * @Gedmo\Timestampable(
     *     on="create",
     * )
     */
    protected $createdAt;

    /**
     * Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="classifieds")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    protected $tag;

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
     * @return Classified
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
     * Set email
     *
     * @param string $email
     * @return Classified
     */
     public function setEmail($email)
     {
        $this->email = $email;

        return $this;
     }

    /**
     * Get $email
     *
     * @return integer
     */
     public function getEmail()
     {
         return $this->email;
     }

      /**
       * Set phone_number
       *
       * @param integer $phone_number
       * @return Classified
       */
      public function setPhoneNumber($phone_number)
       {
          $this->phone_number = $phone_number;

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
     * Set content
     *
     * @param string $content
     * @return Classified
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
     /**
      * Set user
      *
      * @param \AppBundle\Entity\User $user
      * @return Classified
      */
     public function setUser(\AppBundle\Entity\User $user = null)
      {
         $this->user = $user;

         return $this;
      }

      /**
       * Get user
       *
       * @return \AppBundle\Entity\User
       */
      public function getUser()
       {
          return $this->user;
       }


    /**
     * Set price
     *
     * @param integer $price
     * @return Classified
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
        * Set tag
        *
        * @param \AppBundle\Entity\Tag $tag
        * @return Classified
        */
       public function setTag(\AppBundle\Entity\Tag $tag = null)
       {
           $this->tag = $tag;

           return $this;
       }

       /**
        * Get tag
        *
        * @return \AppBundle\Entity\Tag
        */
       public function getTag()
       {
           return $this->tag;
       }



    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Classified
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
