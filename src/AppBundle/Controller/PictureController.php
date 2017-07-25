<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Picture controller.
 *
 * @Route("/")
 */
class PictureController extends Controller
{
    /**
     * Lists all picture entities.
     *
     * @Route("/", name="_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pictures = $em->getRepository('AppBundle:Picture')->findAll();

        return $this->render('picture/index.html.twig', array(
            'pictures' => $pictures,
        ));
    }

    /**
     * Creates a new picture entity.
     *
     * @Route("/new", name="_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $picture = new Picture();
        $form = $this->createForm('AppBundle\Form\PictureType', $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //dump($form->getData());
            $em->persist($picture);
            //dump($form->getData());die;
            $em->flush();

            return $this->redirectToRoute('_index');
        }

        return $this->render('picture/new.html.twig', array(
            'picture' => $picture,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/{id}", name="_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $picture = $em->getRepository('AppBundle:Picture')->find($id);
        // 404
        if(!$picture)
            throw $this->createNotFoundException('Picture not found');

        $deleteForm = $this->createDeleteForm($picture);
        $editForm = $this->createForm('AppBundle\Form\PictureType', $picture);

        //only if POST method
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_show', array('id' => $picture->getId()));
        }

        return $this->render('picture/show.html.twig', array(
            'picture' => $picture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a picture entity.
     *
     * @Route("/{id}", name="_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Picture $picture)
    {
        $form = $this->createDeleteForm($picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();
        }

        return $this->redirectToRoute('_index');
    }

    /**
     * Creates a form to delete a picture entity.
     *
     * @param Picture $picture The picture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Picture $picture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('id' => $picture->getId(), 'comment' => $picture->getComment())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
