<?php

namespace Src;

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
     */
    private $auctionId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="reason", type="integer", nullable=false)
     */
    private $reason = '0';

    /**
     * @return int
     */
    public function getAuctionModerationId()
    {
        return $this->auctionModerationId;
    }

    /**
     * @param int $auctionModerationId
     */
    public function setAuctionModerationId($auctionModerationId)
    {
        $this->auctionModerationId = $auctionModerationId;
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

