<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuctionTypes
 *
 * @ORM\Table(name="auction_types")
 * @ORM\Entity
 */
class AuctionTypes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="auction_type_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $auctionTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=32, nullable=true)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="language_string", type="string", length=32, nullable=true)
     */
    private $languageString;

    /**
     * @return int
     */
    public function getAuctionTypeId()
    {
        return $this->auctionTypeId;
    }

    /**
     * @param int $auctionTypeId
     */
    public function setAuctionTypeId($auctionTypeId)
    {
        $this->auctionTypeId = $auctionTypeId;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getLanguageString()
    {
        return $this->languageString;
    }

    /**
     * @param string $languageString
     */
    public function setLanguageString($languageString)
    {
        $this->languageString = $languageString;
    }


}

