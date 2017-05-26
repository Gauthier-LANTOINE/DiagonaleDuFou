<?php


namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Challenge;
use CoreBundle\Form\ChallengeType;
use CoreBundle\Entity\ChessGame;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
/**
 * Controlleur de la zone de jeu en différé
 *
 * @author Gauthier_LANTOINE
 */
class ChessController extends Controller{
    
    
    public function listCurrentGameAction()
    {
        
        return $this->render('CoreBundle:Chess:listCurrentGame.html.twig');
    }
    /**
     * Action de la route /chess-game/challenge
     * affiche le formulaire proposant de défier les autres membres ayant un compte utilisateur
     * 
     * @param Request $request
     */
    public function challengeAction(Request $request)
    {
        $challenge = new Challenge();
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create(ChallengeType::class, $challenge,array(
            'token_storage' => $this->get('security.token_storage')
                ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $member = $this->getUser()->getMember();
            $challenge->setMemberChallenger($member);
            $em->persist($challenge);
            $em->flush();

            $request->getSession()->getFlashBag()
                    ->add('notice', 'Défi envoyé à '.$challenge->getMemberChallenged()->getFirstName().' '.$challenge->getMemberChallenged()->getLastName().'.');

            return $this->redirectToRoute('core_challenge_game');
        }
        
        $memberChallenged=$this->getUser()->getMember();
        
        $listChallenges = $em->getRepository('CoreBundle:Challenge')->getUnansweredChallenge($memberChallenged);


        
        return $this->render('CoreBundle:Chess:challenge.html.twig',array(
                    'form' => $form->createView(),
                    'listChallenges'=>$listChallenges
                    
        ));
    }
    
    /**
     * Action de la route /chess-game/challenge/decision/accept/{$id}
     * permettant d'accepter un défi.
     * 
     * @ParamConverter("challenge", options={"mapping": {"id": "id"}})
     * @param Challenge $challenge
     */
    public function acceptChallengeAction(Challenge $challenge)
    {
        $chessGame=new ChessGame();
        
        $challenge->setChallengeAccepted(TRUE);
        $challenge->setChessGame($chessGame);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return $this->redirectToRoute('core_challenge_game');
        
    }
    /**
     * Action de la route /chess-game/challenge/decision/refuse/{$id}
     * permettant de refuser un défi.
     * 
     * @ParamConverter("challenge", options={"mapping": {"id": "id"}})
     * @param Challenge $challenge
     */
    public function refuseChallengeAction(Challenge $challenge)
    {
        $challenge->setChallengeAccepted(FALSE);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return $this->redirectToRoute('core_challenge_game');
    }
    
}
