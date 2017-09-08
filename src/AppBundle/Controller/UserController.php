<?php
/**
 * User controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\FormType;
use AppBundle\Form\UserType;
use WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle;
use AppBundle\Repository\UserRepository;

/**
 * Class UserController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     name="users_index",
     *     defaults={"page":1},
     * )
     * @Route(
     *     "/page/{page}",
     *     name="user_index_paginated",
     *     requirements={"page":"[1-9]\d*"},
     * )
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $users = $this->get('app.repository.user')->findAllPaginated($page);


        return $this->render(
            'user/index.html.twig',
            ['users' => $users]
        );
    }
    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/edit/{id}",
     *     requirements={"id": "\d+"},
     *     name="user_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.user')->save($user);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('users_index');
        }

        return $this->render(
            'user/edit.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/delete/{id}",
     *     requirements={"id": "\d+"},
     *     name="user_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.repository.user')->delete($user);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/delete.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

}
