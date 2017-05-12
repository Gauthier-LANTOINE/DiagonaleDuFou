<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use GL\WebsiteAdminBundle\Entity\Articles;

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

}
