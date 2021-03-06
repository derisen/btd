<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArtworkRole;
use AppBundle\Form\Artwork\ArtworkRoleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ArtworkRole controller.
 *
 * @Route("/artwork_role")
 */
class ArtworkRoleController extends Controller {

    /**
     * Lists all ArtworkRole entities.
     *
     * @Route("/", name="artwork_role_index")
     * @Method("GET")
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $dql = 'SELECT e FROM AppBundle:ArtworkRole e ORDER BY e.id';
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $artworkRoles = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'artworkRoles' => $artworkRoles,
        );
    }

    /**
     * Creates a new ArtworkRole entity.
     *
     * @Route("/new", name="artwork_role_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     */
    public function newAction(Request $request) {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $artworkRole = new ArtworkRole();
        $form = $this->createForm(ArtworkRoleType::class, $artworkRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artworkRole);
            $em->flush();

            $this->addFlash('success', 'The new artworkRole was created.');
            return $this->redirectToRoute('artwork_role_show', array('id' => $artworkRole->getId()));
        }

        return array(
            'artworkRole' => $artworkRole,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a ArtworkRole entity.
     *
     * @Route("/{id}", name="artwork_role_show")
     * @Method("GET")
     * @Template()
     * @param ArtworkRole $artworkRole
     */
    public function showAction(ArtworkRole $artworkRole) {

        return array(
            'artworkRole' => $artworkRole,
        );
    }

    /**
     * Displays a form to edit an existing ArtworkRole entity.
     *
     * @Route("/{id}/edit", name="artwork_role_edit")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @param ArtworkRole $artworkRole
     */
    public function editAction(Request $request, ArtworkRole $artworkRole) {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $editForm = $this->createForm(ArtworkRoleType::class, $artworkRole);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'The artworkRole has been updated.');
            return $this->redirectToRoute('artwork_role_show', array('id' => $artworkRole->getId()));
        }

        return array(
            'artworkRole' => $artworkRole,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a ArtworkRole entity.
     *
     * @Route("/{id}/delete", name="artwork_role_delete")
     * @Method("GET")
     * @param Request $request
     * @param ArtworkRole $artworkRole
     */
    public function deleteAction(Request $request, ArtworkRole $artworkRole) {
        if( ! $this->isGranted('ROLE_CONTENT_ADMIN')) {
            $this->addFlash('danger', 'You must login to access this page.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($artworkRole);
        $em->flush();
        $this->addFlash('success', 'The artworkRole was deleted.');

        return $this->redirectToRoute('artwork_role_index');
    }

}
