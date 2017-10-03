<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bids
 *
 * @ORM\Table(name="bids")
 * @ORM\Entity
 */
class Bids
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bid_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bidId;

    /**
     * @var integer
     *
     * @ORM\Column(name="auction_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Auctions")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="auction_id")
     */
    private $auctionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="bid", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $bid;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getBidId()
    {
        return $this->bidId;
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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

