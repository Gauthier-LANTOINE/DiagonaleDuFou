<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\SubCategoryArticle;
use GL\WebsiteAdminBundle\Form\SubCategoryArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SubCategoryArticleController extends Controller {

    public function addAction(Request $request) {

        $subCategory = new SubCategoryArticle();
        $form = $this->get('form.factory')->create(SubCategoryArticleType::class, $subCategory);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($subCategory);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Sous catégorie bien enregistrée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }


        return $this->render('GLWebsiteAdminBundle:SubCategoryArticle:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("subCategoryArticle", options={"mapping": {"id": "id"}})
     */
    public function editAction(SubCategoryArticle $subCategoryArticle, Request $request) {

        $form = $this->get('form.factory')->create(SubCategoryArticleType::class, $subCategoryArticle);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Sous catégorie d\'article bien modifiée.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:SubCategoryArticle:edit.html.twig', array(
                    'subCategoryArticle' => $subCategoryArticle,
                    'form' => $form->createView(),
        ));
    }

    public function listAction($action) {

        $em = $this->getDoctrine()->getManager();

        $listSubCategoryArticles = $em->getRepository('GLWebsiteAdminBundle:SubCategoryArticle')->findAll();

        return $this->render('GLWebsiteAdminBundle:SubCategoryArticle:list.html.twig', array('action' => $action, 'listSubCategoryArticles' => $listSubCategoryArticles));
    }

    /**
     * @ParamConverter("subCategoryArticle", options={"mapping": {"id": "id"}})
     */
    public function removeAction(SubCategoryArticle $subCategoryArticle, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($subCategoryArticle);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Sous catégorie d\'article bien supprimé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:SubCategoryArticle:remove.html.twig', array(
                    'subCategoryArticle' => $subCategoryArticle,
                    'form' => $form->createView(),
        ));
    }

}
