<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use GL\WebsiteAdminBundle\Entity\Articles;
use GL\WebsiteAdminBundle\Entity\Member;
use CoreBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;

class WebsitePortalController extends Controller {

    /**
     * Affiche l'accueil avec les 4 derniers articles
     */
    public function indexAction() {
        $listArticles = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('GLWebsiteAdminBundle:Articles')
                ->getLastFourArticles();

        return $this->render('CoreBundle:WebsitePortal:index.html.twig', array('listArticles' => $listArticles));
    }

    /**
     * @ParamConverter("article", options={"mapping": {"slug": "slug"}})
     */
    public function articleAction(Articles $article) {
        
       return $this->render('CoreBundle:WebsitePortal:article.html.twig', array('article' => $article)); 
        
    }
    
    public function registerAction(Request $request) {

        $member= new Member();
        
        $form = $this->get('form.factory')->create(RegisterType::class, $member);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                   
              $em = $this->getDoctrine()->getManager();
              $em->persist($member);
              $em->flush();              

            $request->getSession()->getFlashBag()
                    ->add('notice', 'Votre compte à été créé ,'
                    . ' vous recevrez un mail lorsque votre compte sera validé.');

            return $this->redirectToRoute('core_register');
        }

        return $this->render('CoreBundle:WebsitePortal:register.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
