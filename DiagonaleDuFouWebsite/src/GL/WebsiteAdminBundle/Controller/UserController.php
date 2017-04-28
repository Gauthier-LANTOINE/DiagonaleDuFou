<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function listAction($action)
    {
        //recherche de la liste des utilisateurs a réaliser
        //retourne l'action et la liste des articles
        return $this->render('GLWebsiteAdminBundle:User:list.html.twig',array('action'=>$action));
    }
}
