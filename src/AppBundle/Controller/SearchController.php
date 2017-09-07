<?php
/**
 * Search controller.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * Classified action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param integer                                   $page    Current page number
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/classifieds",
     *     defaults={"page": 1},
     *     name="classified_search_index",
     * )
     * @Route(
     *     "/classifieds/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="classified_search_index_paginated",
     * )
     * @Method("GET")
     */
    public function classifiedAction(Request $request, $page)
    {
        $string = $request->query->get('string');
        $classifieds = $this->get('app.repository.classified')->findAllPaginated($page, $string);

        return $this->render(
            'classified/index.html.twig',
            ['classifieds' => $classifieds, 'string' => $string]
        );
    }

}