<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\CategoryEvent;
use GL\WebsiteAdminBundle\Form\CategoryEventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryEventController extends Controller {
    
     /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * 
     * @param Request $request
     */
    public function addAction(Request $request) {

        $category = new CategoryEvent();
        $form = $this->get('form.factory')->create(CategoryEventType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie d\'événements bien enregistrée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }


        return $this->render('GLWebsiteAdminBundle:CategoryEvent:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("categoryEvent", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function editAction(CategoryEvent $categoryEvent, Request $request) {

        $form = $this->get('form.factory')->create(CategoryEventType::class, $categoryEvent);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie d\'événements bien modifiée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:CategoryEvent:edit.html.twig', array(
                    'categoryEvent' => $categoryEvent,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * 
     * @param type $action
     */
    public function listAction($action) {

        $em = $this->getDoctrine()->getManager();

        $listCategoryEvents = $em->getRepository('GLWebsiteAdminBundle:CategoryEvent')->findAll();

        return $this->render('GLWebsiteAdminBundle:CategoryEvent:list.html.twig', array('action' => $action, 'listCategoryEvents' => $listCategoryEvents));
    }

    /**
     * @ParamConverter("categoryEvent", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function removeAction(CategoryEvent $categoryEvent, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($categoryEvent);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'catégorie d\'événements bien supprimée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:CategoryEvent:remove.html.twig', array(
                    'categoryEvent' => $categoryEvent,
                    'form' => $form->createView(),
        ));
    }

}