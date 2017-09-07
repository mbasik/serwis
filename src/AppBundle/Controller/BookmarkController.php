<?php
/**
 * Bookmark controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Bookmark;
use AppBundle\Form\BookmarkType;
use AppBundle\Repository\BookmarkRepository;
use AppBundle\Repository\BookmarkCsvRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookmarkController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/bookmark")
 */
class BookmarkController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="bookmark_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="bookmark_index_paginated",
     * )
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $bookmarks = $this->get('app.repository.csvbookmark')->findAll();

        return $this->render(
            'bookmark/index.html.twig',
            ['bookmarks' => $bookmarks]
        );
    }
    /**
     * View action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="bookmark_view",
     * )
     * @Method("GET")
     */
    public function viewAction($id)
    {
             $bookmark = $this->get('app.repository.csvbookmark')->findOneById($id);
        
              return $this->render(
                  'bookmark/view.html.twig',
                  ['bookmark' => $bookmark]
              );
    }
    /**
    * Add action.
    *
    * @param \Symfony\Component\HttpFoundation\Request HTTP Request
    *
    * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
    *
    * @Route(
    *   "/add",
    *   name ="bookmark_add",
    * )
    * @Method({"GET", "POST"})
    */
    public function addAction(Request $request)
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(BookmarkType::class, $bookmark); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.form.bookmarks')->save($bookmark);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('bookmark_index_paginated');
        }

        return $this->render(
            'bookmark/add.html.twig',
            ['bookmark' => $bookmark, 'form' => $form->createView()]
            );
    }

    /**
    * Edit action.
    *
    * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
    * @param \AppBundle\Entity\Bookmark                $bookmark Bookmark entity
    * 
    * @return \Symfony\Component\HttpFoundation\Response HTTP Response
    *
    * @Route(
    *   "/{id}/edit",
    *   requirements={"id": "[1-9]\d*"},
    *   name="bookmark_edit",
    * )
    * @Method({"GET", "POST"})
    */
    public function editAction(Request $request, Bookmark $bookmark)
    {
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->get('app.repository.bookmark')->save($bookmark);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('bookmark_index');
        }

        return $this->render(
            'bookmark/edit.html.twig',
            ['bookmark'=> $bookmark, 'form'=> $form->createView()]
            );
    }
}