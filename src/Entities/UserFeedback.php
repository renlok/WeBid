<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFeedback
 *
 * @ORM\Table(name="user_feedback")
 * @ORM\Entity
 */
class UserFeedback
{
    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $feedbackId;

    /**
     * @var integer
     *
     * @ORM\Column(name="rated_user_id", type="integer", nullable=false)
     */
    private $ratedUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="rated_username", type="string", length=20, nullable=false)
     */
    private $ratedUsername;

    /**
     * @var integer
     *
     * @ORM\Column(name="rater_user_id", type="integer", nullable=false)
     */
    private $raterUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="rater_username", type="string", length=20, nullable=false)
     */
    private $raterUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="feedback_message", type="text", length=16777215, nullable=false)
     */
    private $feedbackMessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var integer
     *
     * @ORM\Column(name="auction_id", type="integer", nullable=false)
     */
    private $auctionId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getFeedbackId()
    {
        return $this->feedbackId;
    }

    /**
     * @param int $feedbackId
     */
    public function setFeedbackId($feedbackId)
    {
        $this->feedbackId = $feedbackId;
    }

    /**
     * @return int
     */
    public function getRatedUserId()
    {
        return $this->ratedUserId;
    }

    /**
     * @param int $ratedUserId
     */
    public function setRatedUserId($ratedUserId)
    {
        $this->ratedUserId = $ratedUserId;
    }

    /**
     * @return string
     */
    public function getRatedUsername()
    {
        return $this->ratedUsername;
    }

    /**
     * @param string $ratedUsername
     */
    public function setRatedUsername($ratedUsername)
    {
        $this->ratedUsername = $ratedUsername;
    }

    /**
     * @return int
     */
    public function getRaterUserId()
    {
        return $this->raterUserId;
    }

    /**
     * @param int $raterUserId
     */
    public function setRaterUserId($raterUserId)
    {
        $this->raterUserId = $raterUserId;
    }

    /**
     * @return string
     */
    public function getRaterUsername()
    {
        return $this->raterUsername;
    }

    /**
     * @param string $raterUsername
     */
    public function setRaterUsername($raterUsername)
    {
        $this->raterUsername = $raterUsername;
    }

    /**
     * @return string
     */
    public function getFeedbackMessage()
    {
        return $this->feedbackMessage;
    }

    /**
     * @param string $feedbackMessage
     */
    public function setFeedbackMessage($feedbackMessage)
    {
        $this->feedbackMessage = $feedbackMessage;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getAuctionId()
    {
        return $this->auctionId;
    }

    /**
     * @param int $auctionId
     */
    public function setAuctionId($auctionId)
    {
        $this->auctionId = $auctionId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}

