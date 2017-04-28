<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function listAction($action)
    {
        //recherche de la liste des articles a réaliser
        //retourne l'action et la liste des articles
        return $this->render('GLWebsiteAdminBundle:Article:list.html.twig',array('action'=>$action));
    }
}