<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompleteAuctions
 *
 * @ORM\Table(name="complete_auctions")
 * @ORM\Entity
 */
class CompleteAuctions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="complete_auction_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $completeAuctionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="auction_id", type="integer", nullable=false)
     */
    private $auctionId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="seller_id", type="integer", nullable=false)
     */
    private $sellerId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="winner_id", type="integer", nullable=false)
     */
    private $winnerId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="bid", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $bid = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="auction_title", type="string", length=70, nullable=true)
     */
    private $auctionTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="auction_shipping_cost", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $auctionShippingCost = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="auction_payment", type="text", length=255, nullable=true)
     */
    private $auctionPayment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="winner_feedback_sent", type="boolean", nullable=false)
     */
    private $winnerFeedbackSent = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="seller_feedback_sent", type="boolean", nullable=false)
     */
    private $sellerFeedbackSent = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_paid", type="boolean", nullable=false)
     */
    private $isPaid = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="buyer_fee_paid", type="boolean", nullable=false)
     */
    private $buyerFeePaid = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="final_fee_paid", type="boolean", nullable=false)
     */
    private $finalFeePaid = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_shipped", type="boolean", nullable=false)
     */
    private $isShipped = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended_at", type="datetime", nullable=false)
     */
    private $endedAt;

    /**
     * @return int
     */
    public function getCompleteAuctionId()
    {
        return $this->completeAuctionId;
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
     * @return int
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * @param int $sellerId
     */
    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;
    }

    /**
     * @return int
     */
    public function getWinnerId()
    {
        return $this->winnerId;
    }

    /**
     * @param int $winnerId
     */
    public function setWinnerId($winnerId)
    {
        $this->winnerId = $winnerId;
    }

    /**
     * @return string
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * @param string $bid
     */
    public function setBid($bid)
    {
        $this->bid = $bid;
    }

    /**
     * @return string
     */
    public function getAuctionTitle()
    {
        return $this->auctionTitle;
    }

    /**
     * @param string $auctionTitle
     */
    public function setAuctionTitle($auctionTitle)
    {
        $this->auctionTitle = $auctionTitle;
    }

    /**
     * @return string
     */
    public function getAuctionShippingCost()
    {
        return $this->auctionShippingCost;
    }

    /**
     * @param string $auctionShippingCost
     */
    public function setAuctionShippingCost($auctionShippingCost)
    {
        $this->auctionShippingCost = $auctionShippingCost;
    }

    /**
     * @return string
     */
    public function getAuctionPayment()
    {
        return $this->auctionPayment;
    }

    /**
     * @param string $auctionPayment
     */
    public function setAuctionPayment($auctionPayment)
    {
        $this->auctionPayment = $auctionPayment;
    }

    /**
     * @return bool
     */
    public function isWinnerFeedbackSent()
    {
        return $this->winnerFeedbackSent;
    }

    /**
     * @param bool $winnerFeedbackSent
     */
    public function setWinnerFeedbackSent($winnerFeedbackSent)
    {
        $this->winnerFeedbackSent = $winnerFeedbackSent;
    }

    /**
     * @return bool
     */
    public function isSellerFeedbackSent()
    {
        return $this->sellerFeedbackSent;
    }

    /**
     * @param bool $sellerFeedbackSent
     */
    public function setSellerFeedbackSent($sellerFeedbackSent)
    {
        $this->sellerFeedbackSent = $sellerFeedbackSent;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->isPaid;
    }

    /**
     * @param bool $isPaid
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;
    }

    /**
     * @return bool
     */
    public function isBuyerFeePaid()
    {
        return $this->buyerFeePaid;
    }

    /**
     * @param bool $buyerFeePaid
     */
    public function setBuyerFeePaid($buyerFeePaid)
    {
        $this->buyerFeePaid = $buyerFeePaid;
    }

    /**
     * @return bool
     */
    public function isFinalFeePaid()
    {
        return $this->finalFeePaid;
    }

    /**
     * @param bool $finalFeePaid
     */
    public function setFinalFeePaid($finalFeePaid)
    {
        $this->finalFeePaid = $finalFeePaid;
    }

    /**
     * @return bool
     */
    public function isShipped()
    {
        return $this->isShipped;
    }

    /**
     * @param bool $isShipped
     */
    public function setIsShipped($isShipped)
    {
        $this->isShipped = $isShipped;
    }

    /**
     * @return DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * @param DateTime $endedAt
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;
    }


}

