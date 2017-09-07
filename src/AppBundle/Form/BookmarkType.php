<?php
/**
 * Bookmark type.
 */
namespace AppBundle\Form;

use AppBundle\Repository\TagRepository;
use AppBundle\Entity\Bookmark;
use AppBundle\Form\TagsDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookmarkType.
 *
 * @package AppBundle\Form
 */
class BookmarkType extends AbstractType
{

    /**
    * Tag repository.
    *
    * @var TagRepository|null Tag repository
    */
    protected $tagRepository = null;

    /**
    * ClassifiedType constructor.
    *
    * @param TagRepository $tagRepository Tag repository
    */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
          'url',
         UrlType::class,
         [
            'label' => 'label.url',
            'required' => true,
            'attr' => [
                'max_length' => 255,
                'readonly' => (isset($options['data']) && $options['data']->getId()),
            ],
          ]
        );
          $builder->add(
            'tags',
            EntityType::class,
            [
                'label' => 'label.tags',
                'required' => true,
                'attr' => [
                    'max_length' => 255,
                ],
            ]
        );
           $builder->get('tags')->addModelTransformer(
            new TagsDataTransformer($this->tagRepository)
        );
            $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $normData = $form->getNormData();

                if ($normData->getId()) {
                    $data['url'] = $normData->getUrl();
                    $event->setData($data);
                }
            }

);
    }
      /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Bookmark::class,
                'validation_groups' => 'tag-default',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tag_type';
    }
}   