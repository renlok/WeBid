<?php

namespace Src;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuctionVisits
 *
 * @ORM\Table(name="auction_visits")
 * @ORM\Entity
 */
class AuctionVisits
{
    /**
     * @var integer
     *
     * @ORM\Column(name="auction_visits_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $auctionVisitsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="auction_id", type="integer", nullable=false)
     */
    private $auctionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="visits", type="integer", nullable=false)
     */
    private $visits = '0';

    /**
     * @return int
     */
    public function getAuctionVisitsId()
    {
        return $this->auctionVisitsId;
    }

    /**
     * @param int $auctionVisitsId
     */
    public function setAuctionVisitsId($auctionVisitsId)
    {
        $this->auctionVisitsId = $auctionVisitsId;
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
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * @param int $visits
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;
    }


}

