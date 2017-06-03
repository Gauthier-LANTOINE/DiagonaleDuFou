<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Classe contenant toute les informations relative au défis lançé
 *
 * @ORM\Table(name="challenge")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ChallengeRepository")
 */
class Challenge {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Membre qui reçoit le défi
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @var Member 
     */
    private $memberChallenged;

    /**
     * Membre qui lance le défi
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @var Member
     */
    private $memberChallenger;
    
    /**
     * décision de l'adversaire à la proposition de défi
     * @var bool
     * @Assert\Type("bool")
     * @ORM\Column(name="challenge_accepted", type="boolean", nullable=true)
     */
    private $challengeAccepted;
    
    /**
     * Date à laquelle le défi à été lançé
     * @var Datetime
     * @Assert\DateTime()
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    
     /**
     * Partie d'échecs
     * @var ChessGame
     * 
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\ChessGame", cascade={"persist"})
     * @ORM\JoinColumn(name="chess_game_id", referencedColumnName="id", nullable=true)
     */
    private $chessGame;
   
    /**
     * Couleur choisi par la personne qui défi
     * @Assert\Regex("/(blanc|noir)/")
     * @var string
     * @ORM\Column(name="challenger_color", type="string", length=5, nullable=true)
     */
    private $challengerColor;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }


   

    /**
     * Set memberChallenged
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $memberChallenged
     *
     * @return Challenge
     */
    public function setMemberChallenged(\GL\WebsiteAdminBundle\Entity\Member $memberChallenged)
    {
        $this->memberChallenged = $memberChallenged;

        return $this;
    }

    /**
     * Get memberChallenged
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMemberChallenged()
    {
        return $this->memberChallenged;
    }

    /**
     * Set memberChallenger
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $memberChallenger
     *
     * @return Challenge
     */
    public function setMemberChallenger(\GL\WebsiteAdminBundle\Entity\Member $memberChallenger)
    {
        $this->memberChallenger = $memberChallenger;

        return $this;
    }

    /**
     * Get memberChallenger
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMemberChallenger()
    {
        return $this->memberChallenger;
    }

    /**
     * Set challengeAccepted
     *
     * @param boolean $challengeAccepted
     *
     * @return Challenge
     */
    public function setChallengeAccepted($challengeAccepted)
    {
        $this->challengeAccepted = $challengeAccepted;

        return $this;
    }

    /**
     * Get challengeAccepted
     *
     * @return boolean
     */
    public function getChallengeAccepted()
    {
        return $this->challengeAccepted;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Challenge
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set chessGame
     *
     * @param \CoreBundle\Entity\ChessGame $chessGame
     *
     * @return Challenge
     */
    public function setChessGame(\CoreBundle\Entity\ChessGame $chessGame = null)
    {
        $this->chessGame = $chessGame;

        return $this;
    }

    /**
     * Get chessGame
     *
     * @return \CoreBundle\Entity\ChessGame
     */
    public function getChessGame()
    {
        return $this->chessGame;
    }

    /**
     * Set challengerColor
     *
     * @param string $challengerColor
     *
     * @return Challenge
     */
    public function setChallengerColor($challengerColor)
    {
        $this->challengerColor = $challengerColor;

        return $this;
    }

    /**
     * Get challengerColor
     *
     * @return string
     */
    public function getChallengerColor()
    {
        return $this->challengerColor;
    }
}
