<?php

namespace Src;

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
     */
    private $auctionId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="seller_id", type="integer", nullable=false)
     */
    private $sellerId = '0';

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
     * @ORM\Column(name="seller_user_id", type="integer", nullable=false)
     */
    private $sellerUserId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getNotificationQueueId()
    {
        return $this->notificationQueueId;
    }

    /**
     * @param int $notificationQueueId
     */
    public function setNotificationQueueId($notificationQueueId)
    {
        $this->notificationQueueId = $notificationQueueId;
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
    public function getSellerUserId()
    {
        return $this->sellerUserId;
    }

    /**
     * @param int $sellerUserId
     */
    public function setSellerUserId($sellerUserId)
    {
        $this->sellerUserId = $sellerUserId;
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

