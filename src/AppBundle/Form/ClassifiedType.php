<?php
/**
 * Classified type.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Classified;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping\ClassMetadata;




/**
 * Class ClassifiedType.
 *
 * @package AppBundle\Form
 */
class ClassifiedType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label.name',
                'required' => true,
                'attr' => [
                    'max_length' => 128,
                ],
            ]
        );

        $builder->add(
            'content',
            TextareaType::class,
            [
                'label' => 'label.content',
                'required' => true,
                'attr' => [
                    'max_length' => 1000,
                ],
            ]
        );

        $builder->add(
            'price',
            IntegerType::class,
            [
                'label' => 'label.price',
                'required' => true,
                'attr' => [
                    'max_length' => 10,
                ],
            ]
        );

        $builder->add(
            'photo',
            FileType::class,
            [
                'label' => 'label.photo',
                'required' => true,
            ]
        );

        $builder->add(
            'tag',
            EntityType::class,
            array(
                'class' => 'AppBundle:Tag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')->orderBy('t.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'Wybierz...',
                'label' => 'label.tag',
                'required' => true,
            )
        );

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Classified::class,
                'validation_groups' => 'classified-default',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'classified_type';
    }
}