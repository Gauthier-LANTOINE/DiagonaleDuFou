<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Ryanhs\Chess\Chess;

/**
 * ChessGame
 *
 * @ORM\Table(name="chess_game")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ChessGameRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ChessGame extends Chess{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private $finished;
    
     /**
     * @var bool
     *
     * @ORM\Column(name="draw_offer", type="boolean", nullable=false)
     */    
    private $drawOffer;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=7, nullable=true)
     */
    private $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_last_move", type="datetime", nullable=true)
     */
    private $dateLastMove;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * Membre qui joue les blancs
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @var Member 
     */
    private $memberWhite;

    /**
     * Membre qui joue les noirs
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @var Member
     */
    private $memberBlack;



    /**
     * @var array
     *
     * @ORM\Column(name="board", type="array", nullable=true)
     */
    protected $board;
    
    /**
     * @var array
     *
     * @ORM\Column(name="kings", type="array", nullable=true)
     */
    protected $kings;
    
    /**
     * indique le camp pour lequel c'est le tour de jeu
     * 
     * @var string
     *
     * @ORM\Column(name="turn", type="string", length=1, options={"fixed" = true}, nullable=true)
     */
    protected $turn;
    
    /**
     * indique si chaque camp peut roquer
     * @var array
     *
     * @ORM\Column(name="castling", type="array", nullable=true)
     */
    protected $castling;
    
     /**
     * @var int
     *
     * @ORM\Column(name="ep_square", type="integer", nullable=true)
     */
    protected $epSquare;
    
    /**
     * @var int
     *
     * @ORM\Column(name="half_moves", type="integer", nullable=false)
     */
    protected $halfMoves;
    
    /**
     * @var int
     *
     * @ORM\Column(name="move_number", type="integer", nullable=false)
     */
    protected $moveNumber;
    
    /**
     * @var array
     *
     * @ORM\Column(name="history", type="array", nullable=true)
     */
    protected $history;
    
    /**
     * @var array
     *
     * @ORM\Column(name="header", type="array", nullable=true)
     */
    protected $header;
    
    /**
     * @var array
     *
     * @ORM\Column(name="generate_move_cache", type="array", nullable=true)
     */
    protected $generateMovesCache;


    public function __construct() {
        parent::__construct("fen");
        $this->setFinished(false);
        $this->setDrawOffer(false);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set finished
     *
     * @param boolean $finished
     *
     * @return ChessGame
     */
    public function setFinished($finished) {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return bool
     */
    public function getFinished() {
        return $this->finished;
    }
    
    /**
     * Set drawOffer
     *
     * @param boolean $drawOffer
     *
     * @return ChessGame
     */
    public function setDrawOffer($drawOffer) {
        $this->drawOffer = $drawOffer;

        return $this;
    }

    /**
     * Get drawOffer
     *
     * @return bool
     */
    public function getDrawOffer() {
        return $this->drawOffer;
    }

    /**
     * Set result
     *
     * @param string $result
     *
     * @return ChessGame
     */
    public function setResult($result) {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * Set dateStart
     *
     * @return ChessGame
     *
     * @ORM\PrePersist
     */
    public function setDateStart() {
        $this->dateStart = new \Datetime();

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart() {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return ChessGame
     */
    public function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd() {
        return $this->dateEnd;
    }

    /**
     * Set memberWhite
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $memberWhite
     *
     * @return ChessGame
     */
    public function setMemberWhite(\GL\WebsiteAdminBundle\Entity\Member $memberWhite) {
        $this->memberWhite = $memberWhite;

        return $this;
    }

    /**
     * Get memberWhite
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMemberWhite() {
        return $this->memberWhite;
    }

    /**
     * Set memberBlack
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $memberBlack
     *
     * @return ChessGame
     */
    public function setMemberBlack(\GL\WebsiteAdminBundle\Entity\Member $memberBlack) {
        $this->memberBlack = $memberBlack;

        return $this;
    }

    /**
     * Get memberBlack
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMemberBlack() {
        return $this->memberBlack;
    }

    /**
     * permet de changer la date du dernier coup 
     * 
     * géré par un événement Doctrine avant chaque mise à jour
     *
     * @param \DateTime $dateLastMove
     * @ORM\PreUpdate
     * @return ChessGame
     */
    public function setDateLastMove($dateLastMove) {
        $this->dateLastMove = new \DateTime();

        return $this;
    }

    /**
     * Get dateLastMove
     *
     * @return \DateTime
     */
    public function getDateLastMove() {
        return $this->dateLastMove;
    }


    /**
     * Get moveNumber
     *
     * @return integer
     */
    public function getMoveNumber() {
        return $this->moveNumber;
    }
    
    
}
