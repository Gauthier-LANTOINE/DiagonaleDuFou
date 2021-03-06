<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Challenge;
use CoreBundle\Form\ChallengeType;
use CoreBundle\Entity\ChessGame;
use CoreBundle\Entity\Move;
use CoreBundle\Form\MoveType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controlleur de la zone de jeu en différé
 *
 * @author Gauthier_LANTOINE
 */
class ChessController extends Controller {

    /**
     * Action de la route /chess-game/list-current-game
     * retourne l'écran listant les parties en cours
     * @Security("has_role('ROLE_USER')")
     */
    public function listCurrentGameAction() {

        $member = $this->getUser()->getMember();
        $em = $this->getDoctrine()->getManager();
        $listCurrentGames = $em->getRepository('CoreBundle:ChessGame')->memberGameToPlay($member);
        $listWaitingGames = $em->getRepository('CoreBundle:ChessGame')->memberWaitingGame($member);
        return $this->render('CoreBundle:Chess:listCurrentGame.html.twig', 
                array('listCurrentGames' => $listCurrentGames,
                      'listWaitingGames' => $listWaitingGames));
    }

    /**
     * Action de la route /chess-game/list-current-game
     * retourne l'écran listant les parties finies
     *
     *  @Security("has_role('ROLE_USER')")
     */
    public function listFinishedGameAction() {

        $member = $this->getUser()->getMember();
        $em = $this->getDoctrine()->getManager();
        $listFinishedGames = $em->getRepository('CoreBundle:ChessGame')->memberGameFinished($member);

        return $this->render('CoreBundle:Chess:listFinishedGame.html.twig', array('listFinishedGames' => $listFinishedGames));
    }

    /**
     * Action de la route /chess-game/challenge
     * retourne le formulaire proposant de défier les autres membres ayant un compte utilisateur
     * 
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     */
    public function challengeAction(Request $request) {

        $challenge = new Challenge();
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create(ChallengeType::class, $challenge, array(
            'token_storage' => $this->get('security.token_storage')
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $member = $this->getUser()->getMember();
            $challenge->setMemberChallenger($member);
            $em->persist($challenge);
            $em->flush();

            $request->getSession()->getFlashBag()
                    ->add('notice', 'Défi bien envoyé à ' . $challenge->getMemberChallenged()->getFirstName() . ' ' . $challenge->getMemberChallenged()->getLastName() . '.');

            return $this->redirectToRoute('core_challenge_game');
        }

        $curentMember = $this->getUser()->getMember();

        $listChallenges = $em->getRepository('CoreBundle:Challenge')->getUnansweredChallenge($curentMember);
        
        $listChallengesSend = $em->getRepository('CoreBundle:Challenge')->getSendChallenge($curentMember);



        return $this->render('CoreBundle:Chess:challenge.html.twig', array(
                    'form' => $form->createView(),
                    'listChallenges' => $listChallenges,
                    'listChallengesSend' => $listChallengesSend
        ));
    }

    /**
     * Action de la route /chess-game/challenge/decision/accept/{$id}
     * permettant d'accepter un défi. créé une partie d'échecs en assignant les joueurs
     * blanc et noirs
     * 
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("challenge", options={"mapping": {"id": "id"}})
     * @param Challenge $challenge
     */
    public function acceptChallengeAction(Challenge $challenge) {

        $chessGame = new ChessGame();

        //initialise la position par défaut
        $chessGame->reset();

        //assigne chaque camp à chaque membre
        if ($challenge->getChallengerColor() == 'blanc') {
            $chessGame->setMemberWhite($challenge->getMemberChallenger());
            $chessGame->setMemberBlack($challenge->getMemberChallenged());
        } else {
            $chessGame->setMemberWhite($challenge->getMemberChallenged());
            $chessGame->setMemberBlack($challenge->getMemberChallenger());
        }



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
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("challenge", options={"mapping": {"id": "id"}})
     * @param Challenge $challenge
     */
    public function refuseChallengeAction(Challenge $challenge) {
        $challenge->setChallengeAccepted(FALSE);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('core_challenge_game');
    }
    
    /**
     * Action de la route /chess-game/challenge/drop/{$id}
     * permettant de supprimer un défi lancé.
     * 
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("challenge", options={"mapping": {"id": "id"}})
     * @param Challenge $challenge
     */
    public function dropChallengeAction(Challenge $challenge) {
       
        $em = $this->getDoctrine()->getManager();
        $em->remove($challenge);
        $em->flush();

        return $this->redirectToRoute('core_challenge_game');
    }

    /**
     * Validation et persistance des coups joués
     * 
     * 
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("chessGame", options={"mapping": {"id": "id"}})
     * @param ChessGame $chessGame
     */
    public function playGameAction(ChessGame $chessGame, Request $request) {

        $chessService = $this->container->get('core.chess_service');
        $move = new Move($chessGame);
        $orientation = $chessService->orientation($chessGame);
        $opponent = $chessService->opponent($chessGame);
        $drawOffer = $chessService->isDrawOffer($chessGame);
        $form = $this->get('form.factory')->create(MoveType::class, $move);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            // exécute le coup, la valeur retourné est false si le coup n'est pas légal
            // et redirige vers la partie dans ce cas
            if (!$chessService->makeMove($move)) {
                $request->getSession()->getFlashBag()->add('notice', 'Coup invalide');
                return $this->redirectToRoute('core_play_game', array('id' => $chessGame->getId()));
            }

            // vérifie si la partie est dans une position de nulle ou d'échecs et mat 
            // et attribut le résultat
            $chessService->updateResult($move->getChessGame());

            $em = $this->getDoctrine()->getManager();
            $em->persist($move);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Coup envoyé');

            return $this->redirectToRoute('core_list_current_game');
        }
        return $this->render('CoreBundle:Chess:game.html.twig', array('orientation' => $orientation,
                    'chessGame' => $chessGame,
                    'opponent' => $opponent,
                    'form' => $form->createView(),
                    'drawOffer' => $drawOffer));
    }

    /**
     * Action de la route /chess-game/play-game/{id}/draw
     * permettant d'accepter la proposition de partie nulle.
     * redirige vers la partie si il n'y avait pas.
     * 
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("chessGame", options={"mapping": {"id": "id"}})
     * @param ChessGame $chessGame
     * 
     */
    public function acceptDrawAction(ChessGame $chessGame) {

        $chessService = $this->container->get('core.chess_service');
        //Contrôle si le dernier coup était accompagné d'une offre de nulle
        // et enregistre le résultat
        if ($chessService->isDrawOffer($chessGame) && $chessService->orientation($chessGame) !== null) {

            $chessGame->setDateEnd();
            $chessGame->setResult(ChessGame::POSSIBLE_RESULTS[2]);
            $chessGame->setFinished(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('core_list_current_game');
        }

        return $this->redirectToRoute('core_play_game', array('id' => $chessGame->getId()));
    }
    
    /**
     * Action de la route /chess-game/play-game/{id}/surrender
     * 
     * 
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("chessGame", options={"mapping": {"id": "id"}})
     * @param ChessGame $chessGame
     */
    public function surrenderAction(ChessGame $chessGame) {

        $chessService = $this->container->get('core.chess_service');
                    
            if($chessService->orientation($chessGame)==='white'){
                
                $chessGame->setResult(ChessGame::POSSIBLE_RESULTS[1]);
                $chessGame->setFinished(true);
                $chessGame->setDateEnd();
                
            }
            
            if($chessService->orientation($chessGame)==='black'){
                
                $chessGame->setResult(ChessGame::POSSIBLE_RESULTS[0]);
                $chessGame->setFinished(true);
                $chessGame->setDateEnd();
                
            }
            
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('core_list_current_game');
        }

    
    /**
     * Action de la route /chess-game/view-game/{id}
     * permettant de visualisé la partie passé en paramètre
     * 
     * @Security("has_role('ROLE_USER')")
     * 
     * @param ChessGame $chessGame
     * @param Request $request
     */
    public function viewGameAction(ChessGame $chessGame) {

        $chessService = $this->container->get('core.chess_service');
        $orientation = $chessService->orientation($chessGame);
        $opponent = $chessService->opponent($chessGame);

        return $this->render('CoreBundle:Chess:viewGame.html.twig', array('orientation' => $orientation,
                    'chessGame' => $chessGame,
                    'opponent' => $opponent));
    }

}
