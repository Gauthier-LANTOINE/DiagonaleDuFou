<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ChessGame
 *
 * @ORM\Table(name="chess_game")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ChessGameRepository")
 */
class ChessGame {

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
     * @ORM\Column(name="finished", type="boolean")
     */
    private $finished;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=7, nullable=true)
     */
    private $result;

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
     * Set memberWhite
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $memberWhite
     *
     * @return ChessGame
     */
    public function setMemberWhite(\GL\WebsiteAdminBundle\Entity\Member $memberWhite)
    {
        $this->memberWhite = $memberWhite;

        return $this;
    }

    /**
     * Get memberWhite
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMemberWhite()
    {
        return $this->memberWhite;
    }

    /**
     * Set memberBlack
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $memberBlack
     *
     * @return ChessGame
     */
    public function setMemberBlack(\GL\WebsiteAdminBundle\Entity\Member $memberBlack)
    {
        $this->memberBlack = $memberBlack;

        return $this;
    }

    /**
     * Get memberBlack
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMemberBlack()
    {
        return $this->memberBlack;
    }
}
