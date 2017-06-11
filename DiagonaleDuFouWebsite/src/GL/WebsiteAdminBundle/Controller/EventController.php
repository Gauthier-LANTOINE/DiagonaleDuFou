<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\Event;
use GL\WebsiteAdminBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class EventController extends Controller
{
    /**
     * @Security("has_role('ROLE_AUTHOR')")
     * 
     * @param Request $request
     */
    public function addAction(Request $request) {

        $event = new Event();
        $form = $this->get('form.factory')->create(EventType::class, $event);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Evénements bien enregistré.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }


        return $this->render('GLWebsiteAdminBundle:Event:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("event", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction(Event $event, Request $request) {

        $form = $this->get('form.factory')->create(EventType::class, $event);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Evénements bien modifié.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Event:edit.html.twig', array(
                    'event' => $event,
                    'form' => $form->createView(),
        ));
    }
    /**
     * @Security("has_role('ROLE_AUTHOR')")
     * 
     * @param String $action
     */
    public function listAction($action) {

        $em = $this->getDoctrine()->getManager();

        $listEvents = $em->getRepository('GLWebsiteAdminBundle:Event')->getAllFutureEvent();

        return $this->render('GLWebsiteAdminBundle:Event:list.html.twig', array('action' => $action, 'listEvents' => $listEvents));
    }

    /**
     * @ParamConverter("event", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function removeAction(CategoryEvent $event, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Evénement bien supprimé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Event:remove.html.twig', array(
                    'event' => $event,
                    'form' => $form->createView(),
        ));
    }
    
    public function listFutureEventIndexAction() {
        
        $em = $this->getDoctrine()->getManager();
        
        $listEvents = $em->getRepository('GLWebsiteAdminBundle:Event')->getFutureFiveEvent();
        
        
        return $this->render('GLWebsiteAdminBundle:Event:table.html.twig', array('listEvents' => $listEvents));
    }
}