<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\CategoryArticle;
use GL\WebsiteAdminBundle\Form\CategoryArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryArticleController extends Controller {

    public function addAction(Request $request) {

        $category = new CategoryArticle();
        $form = $this->get('form.factory')->create(CategoryArticleType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie bien enregistrée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }


        return $this->render('GLWebsiteAdminBundle:CategoryArticle:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("categoryArticle", options={"mapping": {"id": "id"}})
     */
    public function editAction(CategoryArticle $categoryArticle, Request $request) {

        $form = $this->get('form.factory')->create(CategoryArticleType::class, $categoryArticle);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie d\'article bien modifiée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:CategoryArticle:edit.html.twig', array(
                    'categoryArticle' => $categoryArticle,
                    'form' => $form->createView(),
        ));
    }

    public function listAction($action) {

        $em = $this->getDoctrine()->getManager();

        $listCategoryArticles = $em->getRepository('GLWebsiteAdminBundle:CategoryArticle')->findAll();

        return $this->render('GLWebsiteAdminBundle:CategoryArticle:list.html.twig', array('action' => $action, 'listCategoryArticles' => $listCategoryArticles));
    }

    /**
     * @ParamConverter("categoryArticle", options={"mapping": {"id": "id"}})
     */
    public function removeAction(CategoryArticle $categoryArticle, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($categoryArticle);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'catégorie d\'article bien supprimé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:CategoryArticle:remove.html.twig', array(
                    'categoryArticle' => $categoryArticle,
                    'form' => $form->createView(),
        ));
    }

}
