<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Move
 *
 * @ORM\Table(name="move")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\MoveRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Move
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Case de départ
     * @var string
     *
     * @ORM\Column(name="fromSquare", type="string", length=2, options={"fixed" = true})
     */
    private $fromSquare;

    /**
     * Case d'arrivé
     * @var string
     *
     * @ORM\Column(name="toSquare", type="string", length=2, options={"fixed" = true})
     */
    private $toSquare;

    /**
     * Pièce choisie pour la promotion
     * @var string
     *
     * @ORM\Column(name="promotion", type="string", length=1, nullable=true, options={"fixed" = true})
     */
    private $promotion;
    /**
     * Offre de nulle
     * @var bool
     *
     * @ORM\Column(name="draw_offer", type="boolean", nullable=false)
     */    
    private $drawOffer;
    
    /**
     * Date du coup
     * @var \DateTime
     *
     * @ORM\Column(name="date_move", type="datetime", nullable=true)
     */
    private $dateMove;
    
    /**
     * Partie d'échecs à laquelle le coup est lié
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\ChessGame", inversedBy="moves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chessGame;
    
    /**
     * Constructeur
     * 
     * @param \CoreBundle\Entity\ChessGame $chessGame
     */
    public function __construct(ChessGame $chessGame) {
        
        $this->chessGame=$chessGame;
        $this->promotion='q';
    }
    
    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fromSquare
     *
     * @param string $fromSquare
     *
     * @return Move
     */
    public function setFromSquare($fromSquare)
    {
        $this->fromSquare = $fromSquare;

        return $this;
    }

    /**
     * Get fromSquare
     *
     * @return string
     */
    public function getFromSquare()
    {
        return $this->fromSquare;
    }

    /**
     * Set toSquare
     *
     * @param string $toSquare
     *
     * @return Move
     */
    public function setToSquare($toSquare)
    {
        $this->toSquare = $toSquare;

        return $this;
    }

    /**
     * Get toSquare
     *
     * @return string
     */
    public function getToSquare()
    {
        return $this->toSquare;
    }

    /**
     * Set promotion
     *
     * @param string $promotion
     *
     * @return Move
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return string
     */
    public function getPromotion()
    {
        return $this->promotion;
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
     * Set drawOffer
     *
     * @param boolean $drawOffer
     *
     * @return Move
     */
    public function setDrawOffer($drawOffer)
    {
        $this->drawOffer = $drawOffer;

        return $this;
    }

    /**
     * Get drawOffer
     *
     * @return boolean
     */
    public function getDrawOffer()
    {
        return $this->drawOffer;
    }
    
    /**
     * permet d'insérer la date du coup
     * 
     * géré par un événement Doctrine avant chaque insertion
     *
     * @param \DateTime $dateMove
     * @ORM\PrePersist
     */
    public function setDateMove() {
        $this->dateMove = new \DateTime();
    }
}
