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

        $listUsers = $em->getRepository('GLUserBundle:User')->findByEnabled(FALSE);
        
        return $this->render('GLWebsiteAdminBundle:Admin:index.html.twig',array('listUsers'=>$listUsers));
    }
}
