<?php
/**
 * Photo controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use AppBundle\Form\PhotoType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PhotoController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/photo")
 */
class PhotoController extends Controller
{
    /**
     * Add action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/add",
     *     name="photo_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.photo')->save($photo);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('photo_index');
        }

        return $this->render(
            'photo/add.html.twig',
            ['photo' => $photo, 'form' => $form->createView()]
        );
    }



}