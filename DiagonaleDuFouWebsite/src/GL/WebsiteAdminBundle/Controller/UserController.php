<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function listAction($action)
    {
        $em = $this->getDoctrine()->getManager();

        $listUsers = $em->getRepository('GLUserBundle:User')->findByEnabled(FALSE);
        
        return $this->render('GLWebsiteAdminBundle:User:list.html.twig',array('action'=>$action,'listUsers'=>$listUsers));
    }
}
