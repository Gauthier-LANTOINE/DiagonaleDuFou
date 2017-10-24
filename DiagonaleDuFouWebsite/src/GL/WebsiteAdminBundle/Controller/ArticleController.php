<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\Articles;
use GL\WebsiteAdminBundle\Form\ArticlesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ArticleController extends Controller {

    /**
     * @Security("has_role('ROLE_AUTHOR') or has_role('ROLE_MODERATOR')")
     */
    public function listAction($action) {

        $em = $this->getDoctrine()->getManager();

        if ($action == "validate") {
            $listArticles = $em->getRepository('GLWebsiteAdminBundle:Articles')->findByPublished(FALSE);
        } else {
            $listArticles = $em->getRepository('GLWebsiteAdminBundle:Articles')->findBy(
                        array(),
                        array('id'=>'desc')
                    );
        }


        //retourne l'action et la liste des articles
        return $this->render('GLWebsiteAdminBundle:Article:list.html.twig', array('action' => $action, 'listArticles' => $listArticles));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function writeAction(Request $request) {

        $article = new Articles();
        $form = $this->get('form.factory')->create(ArticlesType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $article->setMember($this->getUser()->getMember());
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
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction(Articles $article, Request $request) {

        $form = $this->get('form.factory')->create(ArticlesType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien modifiée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Article:edit.html.twig', array(
                    'article' => $article,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("article", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function removeAction(Articles $article, Request $request) {

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
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("article", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function validateAction(Articles $article, Request $request) {

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
                    'form' => $form->createView(),
        ));
    }


    public function listValidateAction() {

        $em = $this->getDoctrine()->getManager();

        $listArticles = $em->getRepository('GLWebsiteAdminBundle:Articles')->findByPublished(FALSE);


        return $this->render('GLWebsiteAdminBundle:Article:table.html.twig', array('action' => 'validate', 'listArticles' => $listArticles));
    }

}
