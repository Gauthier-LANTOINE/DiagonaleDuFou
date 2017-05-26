<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use GL\WebsiteAdminBundle\Entity\Articles;
use GL\WebsiteAdminBundle\Entity\Member;
use CoreBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        $listArticles = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('GLWebsiteAdminBundle:Articles')
                ->getLastFourArticles();

        return $this->render('CoreBundle:Default:index.html.twig', array('listArticles' => $listArticles));
    }

    /**
     * @ParamConverter("article", options={"mapping": {"slug": "slug"}})
     */
    public function articleAction(Articles $article) {
        
       return $this->render('CoreBundle:Default:article.html.twig', array('article' => $article)); 
        
    }
    
    public function registerAction(Request $request) {

        $member= new Member();
        
        $form = $this->get('form.factory')->create(RegisterType::class, $member);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

              $email = $form->get('email')->getData();
              $member->getUser()->setEmail($email);
                   
              $em = $this->getDoctrine()->getManager();
              $em->persist($member);
              $em->flush();              

            $request->getSession()->getFlashBag()->add('notice', 'Membre bien enregistré.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('CoreBundle:Default:register.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
