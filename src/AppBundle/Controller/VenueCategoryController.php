<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\VenueCategory;
use AppBundle\Form\VenueCategoryType;

/**
 * VenueCategory controller.
 *
 * @Route("/venue_category")
 */
class VenueCategoryController extends Controller {

    /**
     * Lists all VenueCategory entities.
     *
     * @Route("/", name="venue_category_index")
     * @Method("GET")
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $dql = 'SELECT e FROM AppBundle:VenueCategory e ORDER BY e.id';
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $venueCategories = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'venueCategories' => $venueCategories,
        );
    }

    /**
     * Creates a new VenueCategory entity.
     *
     * @Route("/new", name="venue_category_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     */
    public function newAction(Request $request) {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $venueCategory = new VenueCategory();
        $form = $this->createForm('AppBundle\Form\VenueCategoryType', $venueCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($venueCategory);
            $em->flush();

            $this->addFlash('success', 'The new venueCategory was created.');
            return $this->redirectToRoute('venue_category_show', array('id' => $venueCategory->getId()));
        }

        return array(
            'venueCategory' => $venueCategory,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a VenueCategory entity.
     *
     * @Route("/{id}", name="venue_category_show")
     * @Method("GET")
     * @Template()
     * @param VenueCategory $venueCategory
     */
    public function showAction(VenueCategory $venueCategory) {

        return array(
            'venueCategory' => $venueCategory,
        );
    }

    /**
     * Displays a form to edit an existing VenueCategory entity.
     *
     * @Route("/{id}/edit", name="venue_category_edit")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @param VenueCategory $venueCategory
     */
    public function editAction(Request $request, VenueCategory $venueCategory) {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $editForm = $this->createForm('AppBundle\Form\VenueCategoryType', $venueCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'The venueCategory has been updated.');
            return $this->redirectToRoute('venue_category_show', array('id' => $venueCategory->getId()));
        }

        return array(
            'venueCategory' => $venueCategory,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a VenueCategory entity.
     *
     * @Route("/{id}/delete", name="venue_category_delete")
     * @Method("GET")
     * @param Request $request
     * @param VenueCategory $venueCategory
     */
    public function deleteAction(Request $request, VenueCategory $venueCategory) {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($venueCategory);
        $em->flush();
        $this->addFlash('success', 'The venueCategory was deleted.');

        return $this->redirectToRoute('venue_category_index');
    }

}
