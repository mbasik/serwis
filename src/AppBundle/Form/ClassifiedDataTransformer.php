<?php
/**
 * Publishers data transformer.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Publisher;
use AppBundle\Repository\PublisherRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class PublishersDataTransformer.
 *
 * @package AppBundle\Form
 */
class PublishersDataTransformer implements DataTransformerInterface
{
    /**
     * Publisher repository.
     *
     * @var PublisherRepository|null $publisherRepository
     */
    protected $publisherRepository = null;

    /**
     * PublishersDataTransformer constructor.
     *
     * @param PublisherRepository $publisherRepository Publisher repository
     */
    public function __construct(PublisherRepository $publisherRepository){
        $this->publisherRepository = $publisherRepository;
    }

    /**
     * Transform array of publishers to string of names.
     *
     * @param array $publishers Publishers entity array
     *
     * @return string Result
     */
    public function transform($publishers){
        if (null == $publishers){
            return '';
        }

        $publishersNames = [];

        foreach ($publishers as $publisher) {
            $publisherNames[] = $publisher->getName();
        }

        return implode(',', $publisherNames);
    }

    /**
     * Transform string of publisher names into array of Publisher entities.
     *
     * @param string $string String of publisher names
     *
     * @return array Result
     */
    public function reverseTransform($string)
    {
        $publisherNames = explode(',', $string);

        $publishers = [];
        foreach ($publisherNames as $publisherName) {
            if (trim($publisherName) !== '') {
                $publisher = $this->publisherRepository->findOneByName($publisherName);
                if (null == $publisher) {
                    $publisher = new Publisher();
                    $publisher->setName($publisherName);
                    $this->publisherRepository->save($publisher);
                }
                $publishers[] = $publisher;
            }
        }

        return $publishers;
    }
}