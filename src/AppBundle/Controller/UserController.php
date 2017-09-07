<?php
/**
 * User controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

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
     *     name="user_index",
     * )
     * @Method("GET")
     */
    public function indexAction()
    {
        $users = $this->get('fos_user.user_manager')->findUsers();

        return $this->render(
            'user/index.html.twig',
            ['users' => $users]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\User                    $user    User entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('fos_user.user_manager')->updateUser($user);
            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/edit.html.twig',
            ['user' => $user, 'form' => $form->createView()]
        );
    }

    /**
     * Promote action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\User                    $user    User entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/promote",
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_promote",
     * )
     * @Method({"GET", "POST"})
     */
    public function promoteAction(Request $request, User $user)
    {
        if ($user->hasRole('ROLE_ADMIN')) {
            $this->addFlash('danger', 'message.already_admin');

            return $this->redirectToRoute('user_index');
        }

        $form = $this->createForm(FormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->addRole('ROLE_ADMIN');
            $this->get('fos_user.user_manager')->updateUser($user);
            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/promote.html.twig',
            ['user' => $user, 'form' => $form->createView()]
        );
    }

    /**
     * Demote action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\User                    $user    User entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}/demote",
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_demote",
     * )
     * @Method({"GET", "POST"})
     */
    public function demoteAction(Request $request, User $user)
    {
        if ($this->getUser() == $user) {
            $this->addFlash('danger', 'message.cant_demote');

            return $this->redirectToRoute('user_index');
        }
        if (!$user->hasRole('ROLE_ADMIN')) {
            $this->addFlash('danger', 'message.already_user');

            return $this->redirectToRoute('user_index');
        }

        $form = $this->createForm(FormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->removeRole('ROLE_ADMIN');
            $this->get('fos_user.user_manager')->updateUser($user);
            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/demote.html.twig',
            ['user' => $user, 'form' => $form->createView()]
        );
    }
}
