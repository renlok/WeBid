<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuctionModeration
 *
 * @ORM\Table(name="auction_moderation")
 * @ORM\Entity
 */
class AuctionModeration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="auction_moderation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $auctionModerationId;

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
     * @ORM\Column(name="reason", type="string", nullable=false)
     */
    private $reason;

    /**
     * @return int
     */
    public function getAuctionModerationId()
    {
        return $this->auctionModerationId;
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
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param int $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }


}

