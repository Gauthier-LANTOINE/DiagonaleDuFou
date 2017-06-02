<?php

namespace CoreBundle\ChessService;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use CoreBundle\Entity\ChessGame;
use CoreBundle\Entity\Move;

/**
 * Fournis des méthodes lié aux parties d'échecs
 *
 * @author Gauthier_LANTOINE
 */
class ChessService {
    private $tokenStorage;
    
    public function __construct(TokenStorageInterface $tokenStorage) {
        $this->tokenStorage=$tokenStorage;
    }
    
    /**
     * Retourne le camps du joueur authentifié dans la partie passé en paramêtre
     * retourne null si le joueur authentifié ne participe pas à la partie
     * 
     * @param ChessGame $chessGame
     * @return string|null
     */
    public function orientation(ChessGame $chessGame) {
        $member=$this->tokenStorage->getToken()->getUser()->getMember();
        
        $orientation = null;
        
        if ($member->getId() === $chessGame->getMemberWhite()->getId()) {
            $orientation = "white";
        } 
        
        if($member->getId() === $chessGame->getMemberBlack()->getId())
        {
            $orientation = "black";
        }
        return $orientation;
    }
    
    /**
     * Retourne l'adversaire sous forme d'objet Membre
     * 
     * @param ChessGame $chessGame
     * @return Member|null
     */ 
    public function opponent(ChessGame $chessGame) {
        $member=$this->tokenStorage->getToken()->getUser()->getMember();
        
        $opponent = null;
        
        if ($member->getId() === $chessGame->getMemberWhite()->getId()) {
            $opponent = $chessGame->getMemberBlack();
        } 
        
       if($member->getId() === $chessGame->getMemberBlack()->getId())
        {
            $opponent = $chessGame->getMemberWhite();
        }
        return $opponent;
    }
    
    /**
     * Retourne si le dernier coup de la partie 
     * est accompagné d'une proposition de nulle
     * 
     * @param ChessGame $chessGame
     * @return bolean
     */ 
    public function isDrawOffer(ChessGame $chessGame)
    {
        $lastMove = $chessGame->getMoves()->last();
        
        // dans le cas ou il n'y a pas de dernier coup
        if($lastMove === false){
            return false;
        }
        
        return $lastMove->getDrawOffer();
    }
    
    /**
     * Joue le coup et retourne true si il est légal et false si il est illégal
     * 
     * @param Move $move
     * @return boolean
     */
    public function makeMove(Move $move)
    {
        $moveArray = array(
                'from' => $move->getFromSquare(),
                'to' => $move->getToSquare(),
                'promotion' => $move->getPromotion()
        );
        
        if (is_null($move->getChessGame()->move($moveArray))) {
            return FALSE;
        }
        //assigne le tour à persister
        $move->getChessGame()->setColorTurn($move->getChessGame()->turn());
        return true;
    }
    
    /**
     * détecte si la partie est nulle, ou échecs et mat,
     *  actuallise le score et enregistre la date de fin de partie
     * 
     * @param ChessGame $chessGame
     */
    public function updateResult(ChessGame $chessGame)
    {
        if ($chessGame->inCheckmate() && $chessGame->turn() === 'b'){
                $chessGame->setFinished(true);
                $chessGame->setResult(ChessGame::POSSIBLE_RESULTS[0]);
                $chessGame->setDateEnd();
            }
            
            if ($chessGame->inCheckmate() && $chessGame->turn() === 'w'){
                $chessGame->setFinished(true);
                $chessGame->setResult(ChessGame::POSSIBLE_RESULTS[1]);
                $chessGame->setDateEnd();
            }
            
            if ($chessGame->inDraw()){
                $chessGame->setFinished(true);
                $chessGame->setResult(ChessGame::POSSIBLE_RESULTS[2]);
                $chessGame->setDateEnd();
            }
    }
}
