<?php
/**
 * Photos data transformer.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Photo;
use AppBundle\Repository\PhotoRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class PhotosDataTransformer.
 *
 * @package AppBundle\Form
 */
class PhotosDataTransformer implements DataTransformerInterface
{
    /**
     * Photo repository.
     *
     * @var PhotoRepository|null $photoRepository
     */
    protected $photoRepository = null;

    /**
     * PhotosDataTransformer constructor.
     *
     * @param PhotoRepository $photoRepository Photo repository
     */
    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * Transform array of photos to string of names.
     *
     * @param array $photos Photos entity array
     *
     * @return string Result
     */
    public function transform($photos)
    {
        if (null == $photos) {
            return '';
        }

        $photoNames = [];

        foreach ($photos as $photo) {
            $photoNames[] = $photo->getName();
        }

        return implode(',', $photoNames);
    }

    /**
     * Transform string of photo names into array of Photo entities.
     *
     * @param string $string String of photo names
     *
     * @return array Result
     */
    public function reverseTransform($string)
    {
        $photoNames = explode(',', $string);

        $photos = [];
        foreach ($photoNames as $photoName) {
            if (trim($photoName) !== '') {
                $photo = $this->photoRepository->findOneByName($photoName);
                if (null == $photo) {
                    $photo = new Photo();
                    $photo->setName($photoName);
                    $this->photoRepository->save($photo);
                }
                $photos[] = $photo;
            }
        }

        return $photos;
    }
}