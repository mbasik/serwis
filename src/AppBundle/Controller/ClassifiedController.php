<?php
/**
 * Classified controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Classified;
use Pagerfanta\Pagerfanta;
use AppBundle\Entity\Tag;
use AppBundle\Form\ClassifiedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;

/**
 * Class ClassifiedController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/classified")
 */
class ClassifiedController extends Controller
{
    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="classified_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="classified_index_paginated",
     * )
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $classifieds = $this->get('app.repository.classified')->findAllPaginated($page);

        return $this->render(
            'classified/index.html.twig',
            ['classifieds' => $classifieds]
        );
    }

    /**
     * View action.
     *
     * @param Classified $classified Classified entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="classified_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Classified $classified)
    {
        return $this->render(
            'classified/view.html.twig',
            ['classified' => $classified]
        );
    }


    /**
     * Add action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *   "/add",
     *   name ="classified_add",
     * )
     * @Method({"GET", "POST"})
     */

    public function AddAction(Request $request)
    {
        $classified = new Classified();
        $form = $this->createForm(ClassifiedType::class, $classified);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.classified')->save($classified);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirect($this->generateUrl('classified_index'));
        }

        return $this->render('classified/add.html.twig', array(
            'form' => $form->createView(),
        ));


        return $this->redirectToRoute('classified_index');


        return $this->render('classified/add.html.twig',
            ['classified' => $classified, 'form' => $form->createView()]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\Classified                    $classified    Classified entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="classified_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Classified $classified)
    {
        $form = $this->createForm(FormType::class, $classified);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.classified')->delete($classified);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('classified_index');
        }

        return $this->render(
            'classified/delete.html.twig',
            ['classified' => $classified, 'form' => $form->createView()]
        );
    }


    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\Classified                    $classified    Classified entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="classified_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Classified $classified)
    {
        $form = $this->createForm(ClassifiedType::class);
        $form->setData($classified);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.classified')->save($classified);
            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('classified_view', ['id' => $classified->getId()]);
        }

        return $this->render(
            'classified/edit.html.twig',
            ['classified' => $classified, 'form' => $form->createView()]
        );
    }


}