<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\Link;
use GL\WebsiteAdminBundle\Form\LinkType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LinkController extends Controller {

    /**
     * @Security("has_role('ROLE_MODERATOR')")
     * 
     * @param Request $request
     */
    public function addAction(Request $request) {

        $link = new Link();
        $form = $this->get('form.factory')->create(LinkType::class, $link);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Lien enregistré.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }


        return $this->render('GLWebsiteAdminBundle:Link:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("link", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function editAction(Link $link, Request $request) {

        $form = $this->get('form.factory')->create(LinkType::class, $link);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Lien bien modifié.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Link:edit.html.twig', array(
                    'link' => $link,
                    'form' => $form->createView(),
        ));
    }

    public function listAction($action) {

        $em = $this->getDoctrine()->getManager();

        $listLinks = $em->getRepository('GLWebsiteAdminBundle:Link')->findAll();

        return $this->render('GLWebsiteAdminBundle:Link:list.html.twig', array('action' => $action, 'listLinks' => $listLinks));
    }

    /**
     * @ParamConverter("link", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_SUPER_MODERATOR')")
     */
    public function removeAction(Link $link, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($link);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Lien bien supprimé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Link:remove.html.twig', array(
                    'link' => $link,
                    'form' => $form->createView(),
        ));
    }

}