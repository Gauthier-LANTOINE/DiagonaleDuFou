<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_AUTHOR') or has_role('ROLE_MODERATOR')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listMembers = $em->getRepository('GLWebsiteAdminBundle:Member')->getDisabledUsers();
        
        return $this->render('GLWebsiteAdminBundle:Admin:index.html.twig',array('listMembers'=>$listMembers));
    }
}
