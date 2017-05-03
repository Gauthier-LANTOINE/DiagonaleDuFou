<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\Articles;
use GL\WebsiteAdminBundle\Form\ArticlesType;

class ArticleController extends Controller {

    public function listAction($action) {
        //recherche de la liste des articles a réaliser
        //retourne l'action et la liste des articles
        return $this->render('GLWebsiteAdminBundle:Article:list.html.twig', array('action' => $action));
    }

    public function writeAction(Request $request) {

        $article = new Articles();
        $form = $this->get('form.factory')->create(ArticlesType::class, $article);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien enregistrée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
          }


        return $this->render('GLWebsiteAdminBundle:Article:write.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
