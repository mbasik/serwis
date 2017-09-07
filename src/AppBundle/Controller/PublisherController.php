<?php
/**
 * Publisher controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Publisher;
use AppBundle\Form\PublisherType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PublisherController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/publisher")
 */
class PublisherController extends Controller
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
     *     name="publisher_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="publisher_index_paginated",
     * )
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $authors = $this->get('app.repository.publisher')->findAllPaginated($page);

        return $this->render(
            'publisher/index.html.twig',
            ['publishers' => $publishers]
        );
    }

    /**
     * View action.
     *
     * @param Publisher  $publisher Publisher entity
     * @param integer $page   Page number
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     defaults={"page": 1},
     *     requirements={"id": "[1-9]\d*"},
     *     name="publisher_view",
     * )
     * @Route(
     *     "/{id}/page/{page}",
     *     requirements={"id": "[1-9]\d*","page": "[1-9]\d*"},
     *     name="publisher_view_paginated",
     * )
     * @Method("GET")
     */
    public function viewAction(Publisher $publisher, $page)
    {
        $books = $this->get('app.repository.classified')->findAllPaginatedByAuthor($publisher, $page);

        return $this->render(
            'publisher/view.html.twig',
            ['publisher' => $publisher, 'classifieds' => $classifieds]
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
     *     "/add",
     *     name="publisher_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $publisher = new Publisher();
        $form = $this->createForm(PublisherType::class, $publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.publisher')->save($publisher);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('publisher_index');
        }

        return $this->render(
            'publisher/add.html.twig',
            ['publisher' => $publisher, 'form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\Publisher                  $publisher  Publisher entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="publisher_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Publisher $publisher)
    {
        $form = $this->createForm(PublisherType::class, null, array('validation_groups' => 'publisher-edit'));
        $form->remove('photo');
        $form->setData($publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.publisher')->save($publisher);
            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('publisher_view', ['id' => $publisher->getId()]);
        }

        return $this->render(
            'publisher/edit.html.twig',
            ['publisher' => $publisher, 'form' => $form->createView()]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\Publisher                  $publisher  Publisher entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="publisher_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Publisher $publisher)
    {
        if ($publisher->getBooks()->count()) {
            $this->addFlash('danger', 'message.cannot_delete');

            return $this->redirectToRoute('publisher_view', ['id' => $publisher->getId()]);
        }

        $form = $this->createForm(FormType::class, $publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.publisher')->delete($publisher);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('publisher_index');
        }

        return $this->render(
            'publisher/delete.html.twig',
            ['publisher' => $publisher, 'form' => $form->createView()]
        );
    }
}