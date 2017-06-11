<?php 

//namespace GL\WebsiteAdminBundle\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use GL\UserBundle\Entity\User;
//use GL\WebsiteAdminBundle\Form\UserAdminType;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
//
//class UserController extends Controller
//{
//    /**
//     * @Security("has_role('ROLE_ADMIN')")
//     */
//    public function listAction($action)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        if ($action == "validate") {
//            $listUsers = $em->getRepository('GLUserBundle:User')->findByEnabled(FALSE);
//        } else {
//            $listUsers = $em->getRepository('GLUserBundle:User')->findAll();
//        }
//        
//        
//        return $this->render('GLWebsiteAdminBundle:User:list.html.twig',array('action'=>$action,'listUsers'=>$listUsers));
//    }
//    
//    /**
//     * @Security("has_role('ROLE_ADMIN')")
//     */
//    public function addAction(Request $request) {
//
//        $userManager=$this->get('fos_user.user_manager');
//        
//        $user = $userManager->createUser();
//        $form = $this->get('form.factory')->create(UserAdminType::class, $user);
//
//        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//
//              $tokenGenerator = $this->container->get('fos_user.util.token_generator');
//              $password = substr($tokenGenerator->generateToken(), 0, 12);
//              $user->setPlainPassword($password);
//              $userManager->updateUser($user);
//
//            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');
//
//            return $this->redirectToRoute('gl_website_admin_homepage');
//        }
//
//
//        return $this->render('GLWebsiteAdminBundle:User:add.html.twig', array(
//                    'form' => $form->createView(),
//        ));
//    }
//    
//    /**
//     * @ParamConverter("user", options={"mapping": {"id": "id"}})
//     * @Security("has_role('ROLE_ADMIN')")
//     */
//    public function editAction(User $user, Request $request) {
//
//        $form = $this->get('form.factory')->create(UserAdminType::class, $user);
//
//        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//
//            $userManager = $this->get('fos_user.user_manager');
//            $userManager->updateUser($user);
//
//            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien modifiée.');
//
//            return $this->redirectToRoute('gl_website_admin_homepage');
//        }
//
//        return $this->render('GLWebsiteAdminBundle:User:edit.html.twig', array(
//                    'user' => $user,
//                    'form' => $form->createView(),
//        ));
//    }
//    
//    /**
//     * @ParamConverter("user", options={"mapping": {"id": "id"}})
//     * @Security("has_role('ROLE_SUPER_ADMIN')")
//     */
//    public function removeAction(User $user, Request $request) {
//
//        $form = $this->get('form.factory')->create();
//
//        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//
//            $userManager = $this->get('fos_user.user_manager');
//            $userManager->deleteUser($user);
//
//            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien supprimé.');
//
//            return $this->redirectToRoute('gl_website_admin_homepage');
//        }
//
//        return $this->render('GLWebsiteAdminBundle:User:remove.html.twig', array(
//                    'user' => $user,
//                    'form' => $form->createView(),
//        ));
//    }
//    
//    /**
//     * @ParamConverter("user", options={"mapping": {"id": "id"}})
//     * @Security("has_role('ROLE_ADMIN')")
//     */
//    public function validateAction(User $user, Request $request) {
//
//        $form = $this->get('form.factory')->create();
//
//        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//
//            $userManager = $this->get('fos_user.user_manager');
//            $user->setEnabled(TRUE);
//            $userManager->updateUser($user);
//
//
//            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur Validé.');
//
//            return $this->redirectToRoute('gl_website_admin_homepage');
//        }
//
//        return $this->render('GLWebsiteAdminBundle:User:validate.html.twig', array(
//                    'user' => $user,
//                    'form' => $form->createView(),
//        ));
//    }
//    
//    /**
//     * @ParamConverter("user", options={"mapping": {"id": "id"}})
//     * @Security("has_role('ROLE_ADMIN')")
//     */
//    public function readAction(User $user) {
//
//        return $this->render('GLWebsiteAdminBundle:User:read.html.twig', array(
//                    'user' => $user,
//        ));
//    }
//}
