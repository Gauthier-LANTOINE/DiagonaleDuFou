<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\Articles;
use GL\WebsiteAdminBundle\Form\ArticlesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ArticleController extends Controller {

    public function listAction($action) {
        
        $em = $this->getDoctrine()->getManager();
        
        if($action == "validate"){
            $listArticles = $em->getRepository('GLWebsiteAdminBundle:Articles')->findByPublished(FALSE);
        }
        else{  
            $listArticles = $em->getRepository('GLWebsiteAdminBundle:Articles')->findAll();
        }
        
        
        //retourne l'action et la liste des articles
        return $this->render('GLWebsiteAdminBundle:Article:list.html.twig', array('action' => $action, 'listArticles' => $listArticles));
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
    
 /**
 * @ParamConverter("article", options={"mapping": {"id": "id"}})
 */
    public function editAction(Articles $article,Request $request) {
        
       $form = $this->get('form.factory')->create(ArticlesType::class, $article);
       
       if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Article bien modifiée.');

        return $this->redirectToRoute('gl_website_admin_homepage');
      }
        
       return $this->render('GLWebsiteAdminBundle:Article:write.html.twig', array(
      'article' => $article,
      'form'   => $form->createView(),
    ));
    }
    
 /**
 * @ParamConverter("article", options={"mapping": {"id": "id"}})
 */
    public function removeAction(Articles $article,Request $request) {
        
       $form = $this->get('form.factory')->create();
       
       if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
       
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Article bien supprimé.');

        return $this->redirectToRoute('gl_website_admin_homepage');
      }
        
       return $this->render('GLWebsiteAdminBundle:Article:remove.html.twig', array(
      'article' => $article,
      'form'   => $form->createView(),
    ));
    }
    
 /**
 * @ParamConverter("article", options={"mapping": {"id": "id"}})
 */
    public function validateAction(Articles $article,Request $request) {
        
       $form = $this->get('form.factory')->create();
       
       if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
       
        $article->setPublished(TRUE);
        $article->setPublicationDate(new \Datetime());
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Article Validé.');

        return $this->redirectToRoute('gl_website_admin_homepage');
      }
        
       return $this->render('GLWebsiteAdminBundle:Article:validate.html.twig', array(
      'article' => $article,
      'form'   => $form->createView(),
    ));
    }

}
