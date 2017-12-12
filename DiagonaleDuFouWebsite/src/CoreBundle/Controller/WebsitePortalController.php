<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use GL\WebsiteAdminBundle\Entity\Articles;
use GL\WebsiteAdminBundle\Entity\SubCategoryArticle;
use GL\WebsiteAdminBundle\Entity\Member;
use CoreBundle\Form\RegisterType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;

class WebsitePortalController extends Controller {

    /**
     * Affiche le menu sur le portail web 
     * 
     * @return type
     */
    public function menuAction() {

        $em = $this->getDoctrine()->getManager();

        $listCategories = $em->getRepository('GLWebsiteAdminBundle:CategoryArticle')->findAll();


        return $this->render('CoreBundle:WebsitePortal:menu.html.twig', array('listCategories' => $listCategories));
    }

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
     * Affiche les articles
     * 
     * @ParamConverter("article", options={"mapping": {"slug": "slug"}})
     */
    public function articleAction(Articles $article) {

        return $this->render('CoreBundle:WebsitePortal:article.html.twig', array('article' => $article));
    }

    /**
     * Affiche une listes des articles de la sous catégorie
     * 
     * @ParamConverter("subCategoryArticle", options={"mapping": {"subCategory": "slug"}})
     * @param SubCategoryArticle $subCategoryArticle
     */
    public function subCategoryArticleAction($page, SubCategoryArticle $subCategoryArticle) {

        //aucune page n'existe en dessous de 1
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listArticles = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('GLWebsiteAdminBundle:Articles')
                ->getArticlesBySubCategory($page, 4, $subCategoryArticle);


        $nbPages = ceil(count($listArticles) / 4);


        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }


        return $this->render('CoreBundle:WebsitePortal:subCategory.html.twig', array(
                    'listArticles' => $listArticles,
                    'nbPages' => $nbPages,
                    'page' => $page,
                    'subCategoryArticle' => $subCategoryArticle
        ));
    }

    /**
     * Affiche les articles recherchés
     * 
     */
    public function searchAction(Request $request) {

        if ($request->isMethod('POST') !== TRUE) {
            throw new BadRequestHttpException("Mauvaise requête");
        }
        
        $search = $request->request->get('search');

        $listArticles = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('GLWebsiteAdminBundle:Articles')
                ->getArticlesByTitle(1, 4, $search);


        $nbPages = ceil(count($listArticles) / 4);


        if ($nbPages == 0) {
            throw $this->createNotFoundException("Il n'existe aucun résultat pour cette recherche");
        }


        return $this->render('CoreBundle:WebsitePortal:search.html.twig', array(
                    'listArticles' => $listArticles,
                    'nbPages' => $nbPages,
                    'page' => 1,
                    'search' => $search
        ));

    }

    /**
     * Affiche les articles recherchés celon la page
     * 
     */
    public function searchPageAction($search, $page) {

        //aucune page n'existe en dessous de 1
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listArticles = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('GLWebsiteAdminBundle:Articles')
                ->getArticlesByTitle($page, 4, $search);


        $nbPages = ceil(count($listArticles) / 4);


        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }


        return $this->render('CoreBundle:WebsitePortal:search.html.twig', array(
                    'listArticles' => $listArticles,
                    'nbPages' => $nbPages,
                    'page' => $page,
                    'search' => $search
        ));
    }

    /**
     * Affiche le formulaire d'inscription
     * 
     * @param Request $request
     * @return type
     */
    public function registerAction(Request $request) {

        $member = new Member();

        $form = $this->get('form.factory')->create(RegisterType::class, $member);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $registrationMailer= $this->get('gl_website_admin.email.registration_mailer');
            
            $member->getUser()->setEmail($form->get('email')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
            
            $registrationMailer->sendMemberRegistrationConfirmation($member);

            $request->getSession()->getFlashBag()
                    ->add('notice', 'Votre compte à été créé ,'
                            . ' vous recevrez un mail lorsque votre compte sera validé.');

            return $this->redirectToRoute('core_register');
        }

        return $this->render('CoreBundle:WebsitePortal:register.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les liens sur le portail web
     * 
     * @return type
     */
    public function linkAction() {

        $em = $this->getDoctrine()->getManager();

        $listLinks = $em->getRepository('GLWebsiteAdminBundle:Link')->findBy(
                array(), array('order' => 'asc')
        );


        return $this->render('CoreBundle:WebsitePortal:link.html.twig', array('listLinks' => $listLinks));
    }

}
