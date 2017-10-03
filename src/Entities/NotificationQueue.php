<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationQueue
 *
 * @ORM\Table(name="notification_queue")
 * @ORM\Entity
 */
class NotificationQueue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="notification_queue_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $notificationQueueId;

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
     * @ORM\Column(name="auction_title", type="string", length=255, nullable=false)
     */
    private $auctionTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="seller_username", type="string", length=255, nullable=false)
     */
    private $sellerUsername;

    /**
     * @var integer
     *
     * @ORM\Column(name="seller_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="seller_id", referencedColumnName="user_id")
     */
    private $sellerId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getNotificationQueueId()
    {
        return $this->notificationQueueId;
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
     * @param int $sellerId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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
    public function getSellerUsername()
    {
        return $this->sellerUsername;
    }

    /**
     * @param string $sellerUsername
     */
    public function setSellerUsername($sellerUsername)
    {
        $this->sellerUsername = $sellerUsername;
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

