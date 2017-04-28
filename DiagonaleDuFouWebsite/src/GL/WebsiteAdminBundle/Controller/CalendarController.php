<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendarController extends Controller
{
    public function listAction($action)
    {
        //recherche de la liste des événements a réaliser
        //retourne l'action et la liste des événements
        return $this->render('GLWebsiteAdminBundle:Calendar:list.html.twig',array('action'=>$action));
    }
}