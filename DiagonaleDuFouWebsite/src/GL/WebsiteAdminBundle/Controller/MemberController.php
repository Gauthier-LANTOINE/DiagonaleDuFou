<?php

namespace GL\WebsiteAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GL\WebsiteAdminBundle\Entity\Member;
use GL\WebsiteAdminBundle\Form\MemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MemberController extends Controller {

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listAction($action) {
        $em = $this->getDoctrine()->getManager();

        if ($action == "validate") {
            $listMembers = $em->getRepository('GLWebsiteAdminBundle:Member')->getDisabledUsers();
        } else {
            $listMembers = $em->getRepository('GLWebsiteAdminBundle:Member')->findAll();
        }


        return $this->render('GLWebsiteAdminBundle:Member:list.html.twig', array('action' => $action, 'listMembers' => $listMembers));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request) {

        $member = new Member();

        $form = $this->get('form.factory')->create(MemberType::class, $member);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $email = $form->get('email')->getData();
            if ($email != NULL) {
                $userManager = $this->get('fos_user.user_manager');
                $registrationMailer = $this->get('gl_website_admin.email.registration_mailer');

                $user = $userManager->createUser();
                $member->setUser($user);
                $member->getUser()->setEnabled(TRUE);
                $tokenGenerator = $this->container->get('fos_user.util.token_generator');
                $password = substr($tokenGenerator->generateToken(), 0, 12);
                $member->getUser()->setEmail($email);
                $member->getUser()->setUsername($email);
                $member->getUser()->setPlainPassword($password);

                $registrationMailer->sendMemberRegistrationLogin($password, $member);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Membre bien enregistré.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Member:add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Member $member, Request $request) {

        $form = $this->get('form.factory')->create(MemberType::class, $member);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Membre bien modifié.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Member:edit.html.twig', array(
                    'member' => $member,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function removeAction(Member $member, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            try {
                $registrationMailer = $this->get('gl_website_admin.email.registration_mailer');
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($member);
                $em->flush();
                
                $registrationMailer->sendMemberDeletionConfirmation($member);
                
            } catch (\PDOException $e) {
                $request->getSession()->getFlashBag()
                        ->add('notice',
                              'Impossible de supprimer ce membre, il est possible qu\'il soit lié à au moins une partie d\'échecs' );
                
                return $this->redirectToRoute('gl_website_member_remove', array('id' => $member->getId()));
            }
            $request->getSession()->getFlashBag()->add('notice', 'Membre bien supprimé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Member:remove.html.twig', array(
                    'member' => $member,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function validateAction(Member $member, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $registrationMailer = $this->get('gl_website_admin.email.registration_mailer');

            $member->getUser()->setEnabled(TRUE);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $registrationMailer->sendMemberValidation($member);

            $request->getSession()->getFlashBag()->add('notice', 'Membre Validé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Member:validate.html.twig', array(
                    'member' => $member,
                    'form' => $form->createView(),
        ));
    }
    
    /**
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function invalidateAction(Member $member, Request $request) {

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $registrationMailer = $this->get('gl_website_admin.email.registration_mailer');
                
                $em = $this->getDoctrine()->getManager();
                $em->remove($member);
                $em->flush();

            $registrationMailer->sendMemberInvalidationConfirmation($member);

            $request->getSession()->getFlashBag()->add('notice', 'Membre Supprimé.');

            return $this->redirectToRoute('gl_website_admin_homepage');
        }

        return $this->render('GLWebsiteAdminBundle:Member:validate.html.twig', array(
                    'member' => $member,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("member", options={"mapping": {"id": "id"}})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function readAction(Member $member) {

        return $this->render('GLWebsiteAdminBundle:Member:read.html.twig', array(
                    'member' => $member,
        ));
    }

}
