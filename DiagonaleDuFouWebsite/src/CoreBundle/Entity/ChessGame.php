<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Ryanhs\Chess\Chess;

/**
 * ChessGame
 *
 * @ORM\Table(name="chess_game")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ChessGameRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ChessGame extends Chess {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Valeur indiquant si la partie est terminé
     * @var bool
     * 
     * @ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private $finished;

    /**
     * Résultat de la partie
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=7, nullable=true)
     */
    private $result;

    /**
     * Date de début de la partie
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;


    /**
     * Date de fin de la partie
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
     * coups de la partie
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Move", mappedBy="chessGame")
     * @var Move
     */
    private $moves;
    
    /**
     * Historique contenant la représentation des coup au format SAN
     * ainsi que la position au format fen.
     * 
     * @var array 
     */
    private $sanHistory;
    
    /**
     * Couleur au trait
     * @var string
     *
     * @ORM\Column(name="color_turn", type="string", length=1, nullable=false)
     */
    protected $colorTurn;

    /**
     * Constructeur initialisant les valeurs par défaut.
     */
    public function __construct() {
        parent::__construct("fen");
        $this->setFinished(false);
        $this->colorTurn='w';
        $this->moves = new ArrayCollection();
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
     * Mutateur définisant la date de fin a a date à laquelle est appelé la méthode.
     *
     * @param \DateTime $dateEnd
     */
    public function setDateEnd() {
        $this->dateEnd = new \DateTime();
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

    /**
     * initialise l'état de la partie
     * 
     * @ORM\PostLoad
     */
    public function chessInit() {
        //initialise les header pour la génération de pgn
        $this->header('White', $this->memberWhite->getFirstName().' '.$this->memberWhite->getLastName());
        $this->header('Black', $this->memberBlack->getFirstName().' '.$this->memberBlack->getLastName());
        
        //initialise le compteur de coup et applique la position par défaut
        $this->clear();
        $this->reset();
        
        $arrayW=null;
        $arrayB=null;
        
        //récupère les coups pour remplir l'historique des positions
        foreach ($this->moves as $move) {
            $moveArray = array(
                'from' => $move->getFromSquare(),
                'to' => $move->getToSquare(),
                'promotion' => $move->getPromotion()
            );
            
            $moveResult=$this->move($moveArray);
            
            //si le tour est au noir je récupère le coup 
            //et la position joué par les blancs
            if($this->turn()==='b'){
                $arrayW[]=array(
                'fen'=>$this->fen(),
                'san'=>$moveResult["san"]
            );
            }           
            // et inversement
            if($this->turn()==='w'){
                $arrayB[]=array(
                'fen'=>$this->fen(),
                'san'=>$moveResult["san"]
            );}  
        }
        //remplissage de la variable sanHistory
        $this->sanHistory=array('w'=>$arrayW,'b'=>$arrayB);
    }

    /**
     * Add move
     *
     * @param \CoreBundle\Entity\Move $move
     *
     * @return ChessGame
     */
    public function addMove(\CoreBundle\Entity\Move $move) {
        $this->moves[] = $move;

        return $this;
    }

    /**
     * Remove move
     *
     * @param \CoreBundle\Entity\Move $move
     */
    public function removeMove(\CoreBundle\Entity\Move $move) {
        $this->moves->removeElement($move);
    }

    /**
     * Get moves
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMoves() {
        return $this->moves;
    }
    
    /**
     * Get sanHistory
     *
     * @return array
     */
    public function getSanHistory() {
        return $this->sanHistory;
    }


    /**
     * Set colorTurn
     *
     * @param string $colorTurn
     *
     * @return ChessGame
     */
    public function setColorTurn($colorTurn)
    {
        $this->colorTurn = $colorTurn;

        return $this;
    }

    /**
     * Get colorTurn
     *
     * @return string
     */
    public function getColorTurn()
    {
        return $this->colorTurn;
    }
    
}
