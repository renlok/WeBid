<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auctions
 *
 * @ORM\Table(name="auctions")
 * @ORM\Entity
 */
class Auctions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="auction_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $auctionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=70, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_title", type="string", length=70, nullable=true)
     */
    private $subTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starts_at", type="datetime", nullable=true)
     */
    private $startsAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ends_at", type="datetime", nullable=true)
     */
    private $endsAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_file", type="text", length=255, nullable=true)
     */
    private $pictureFile;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="second_category_id", type="integer", nullable=true)
     */
    private $secondCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="minimum_bid", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $minimumBid = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_cost", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $shippingCost = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="additional_shipping_cost", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $additionalShippingCost = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="reserve_price", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $reservePrice = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="buy_now", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $buyNow = '0.00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="auction_type", type="boolean", nullable=false)
     */
    private $auctionType;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration_id", type="integer", nullable=false)
     */
    private $durationId;

    /**
     * @var string
     *
     * @ORM\Column(name="increment", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $increment = '0.00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="shipping", type="boolean", nullable=false)
     */
    private $shipping = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="payment", type="text", length=255, nullable=true)
     */
    private $payment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="international_shipping", type="boolean", nullable=false)
     */
    private $internationalShipping = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="current_bid", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $currentBid = '0.00';

    /**
     * @var integer
     *
     * @ORM\Column(name="current_bid_id", type="integer", nullable=false)
     */
    private $currentBidId = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean", nullable=false)
     */
    private $isClosed = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_photo", type="boolean", nullable=false)
     */
    private $hasPhoto = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="initial_quantity", type="integer", nullable=false)
     */
    private $initialQuantity = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="remaining_quantity", type="integer", nullable=false)
     */
    private $remainingQuantity = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_suspended", type="boolean", nullable=false)
     */
    private $isSuspended = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="relists_remaining", type="integer", nullable=false)
     */
    private $relistsRemaining = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="relists_used", type="integer", nullable=false)
     */
    private $relistsUsed = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="bid_count", type="integer", nullable=false)
     */
    private $bidCount = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_sold", type="boolean", nullable=false)
     */
    private $isSold = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_terms", type="text", length=255, nullable=true)
     */
    private $shippingTerms;

    /**
     * @var boolean
     *
     * @ORM\Column(name="buy_now_only", type="boolean", nullable=true)
     */
    private $buyNowOnly = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_bold", type="boolean", nullable=true)
     */
    private $isBold = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_highlighted", type="boolean", nullable=true)
     */
    private $isHighlighted = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_featured", type="boolean", nullable=true)
     */
    private $isFeatured = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="current_fee", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $currentFee = '0.00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="tax", type="boolean", nullable=true)
     */
    private $tax = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="tax_included", type="boolean", nullable=true)
     */
    private $taxIncluded = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="buy_now_sale", type="boolean", nullable=true)
     */
    private $buyNowSale = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * @param string $subTitle
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;
    }

    /**
     * @return DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param DateTime $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return DateTime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param DateTime $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }

    /**
     * @param string $pictureFile
     */
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getSecondCategoryId()
    {
        return $this->secondCategoryId;
    }

    /**
     * @param int $secondCategoryId
     */
    public function setSecondCategoryId($secondCategoryId)
    {
        $this->secondCategoryId = $secondCategoryId;
    }

    /**
     * @return string
     */
    public function getMinimumBid()
    {
        return $this->minimumBid;
    }

    /**
     * @param string $minimumBid
     */
    public function setMinimumBid($minimumBid)
    {
        $this->minimumBid = $minimumBid;
    }

    /**
     * @return string
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @param string $shippingCost
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;
    }

    /**
     * @return string
     */
    public function getAdditionalShippingCost()
    {
        return $this->additionalShippingCost;
    }

    /**
     * @param string $additionalShippingCost
     */
    public function setAdditionalShippingCost($additionalShippingCost)
    {
        $this->additionalShippingCost = $additionalShippingCost;
    }

    /**
     * @return string
     */
    public function getReservePrice()
    {
        return $this->reservePrice;
    }

    /**
     * @param string $reservePrice
     */
    public function setReservePrice($reservePrice)
    {
        $this->reservePrice = $reservePrice;
    }

    /**
     * @return string
     */
    public function getBuyNow()
    {
        return $this->buyNow;
    }

    /**
     * @param string $buyNow
     */
    public function setBuyNow($buyNow)
    {
        $this->buyNow = $buyNow;
    }

    /**
     * @return bool
     */
    public function isAuctionType()
    {
        return $this->auctionType;
    }

    /**
     * @param bool $auctionType
     */
    public function setAuctionType($auctionType)
    {
        $this->auctionType = $auctionType;
    }

    /**
     * @return int
     */
    public function getDurationId()
    {
        return $this->durationId;
    }

    /**
     * @param int $durationId
     */
    public function setDurationId($durationId)
    {
        $this->durationId = $durationId;
    }

    /**
     * @return string
     */
    public function getIncrement()
    {
        return $this->increment;
    }

    /**
     * @param string $increment
     */
    public function setIncrement($increment)
    {
        $this->increment = $increment;
    }

    /**
     * @return bool
     */
    public function isShipping()
    {
        return $this->shipping;
    }

    /**
     * @param bool $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return string
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param string $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return bool
     */
    public function isInternationalShipping()
    {
        return $this->internationalShipping;
    }

    /**
     * @param bool $internationalShipping
     */
    public function setInternationalShipping($internationalShipping)
    {
        $this->internationalShipping = $internationalShipping;
    }

    /**
     * @return string
     */
    public function getCurrentBid()
    {
        return $this->currentBid;
    }

    /**
     * @param string $currentBid
     */
    public function setCurrentBid($currentBid)
    {
        $this->currentBid = $currentBid;
    }

    /**
     * @return int
     */
    public function getCurrentBidId()
    {
        return $this->currentBidId;
    }

    /**
     * @param int $currentBidId
     */
    public function setCurrentBidId($currentBidId)
    {
        $this->currentBidId = $currentBidId;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->isClosed;
    }

    /**
     * @param bool $isClosed
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;
    }

    /**
     * @return bool
     */
    public function isHasPhoto()
    {
        return $this->hasPhoto;
    }

    /**
     * @param bool $hasPhoto
     */
    public function setHasPhoto($hasPhoto)
    {
        $this->hasPhoto = $hasPhoto;
    }

    /**
     * @return int
     */
    public function getInitialQuantity()
    {
        return $this->initialQuantity;
    }

    /**
     * @param int $initialQuantity
     */
    public function setInitialQuantity($initialQuantity)
    {
        $this->initialQuantity = $initialQuantity;
    }

    /**
     * @return int
     */
    public function getRemainingQuantity()
    {
        return $this->remainingQuantity;
    }

    /**
     * @param int $remainingQuantity
     */
    public function setRemainingQuantity($remainingQuantity)
    {
        $this->remainingQuantity = $remainingQuantity;
    }

    /**
     * @return bool
     */
    public function isSuspended()
    {
        return $this->isSuspended;
    }

    /**
     * @param bool $isSuspended
     */
    public function setIsSuspended($isSuspended)
    {
        $this->isSuspended = $isSuspended;
    }

    /**
     * @return int
     */
    public function getRelistsRemaining()
    {
        return $this->relistsRemaining;
    }

    /**
     * @param int $relistsRemaining
     */
    public function setRelistsRemaining($relistsRemaining)
    {
        $this->relistsRemaining = $relistsRemaining;
    }

    /**
     * @return int
     */
    public function getRelistsUsed()
    {
        return $this->relistsUsed;
    }

    /**
     * @param int $relistsUsed
     */
    public function setRelistsUsed($relistsUsed)
    {
        $this->relistsUsed = $relistsUsed;
    }

    /**
     * @return int
     */
    public function getBidCount()
    {
        return $this->bidCount;
    }

    /**
     * @param int $bidCount
     */
    public function setBidCount($bidCount)
    {
        $this->bidCount = $bidCount;
    }

    /**
     * @return bool
     */
    public function isSold()
    {
        return $this->isSold;
    }

    /**
     * @param bool $isSold
     */
    public function setIsSold($isSold)
    {
        $this->isSold = $isSold;
    }

    /**
     * @return string
     */
    public function getShippingTerms()
    {
        return $this->shippingTerms;
    }

    /**
     * @param string $shippingTerms
     */
    public function setShippingTerms($shippingTerms)
    {
        $this->shippingTerms = $shippingTerms;
    }

    /**
     * @return bool
     */
    public function isBuyNowOnly()
    {
        return $this->buyNowOnly;
    }

    /**
     * @param bool $buyNowOnly
     */
    public function setBuyNowOnly($buyNowOnly)
    {
        $this->buyNowOnly = $buyNowOnly;
    }

    /**
     * @return bool
     */
    public function isBold()
    {
        return $this->isBold;
    }

    /**
     * @param bool $isBold
     */
    public function setIsBold($isBold)
    {
        $this->isBold = $isBold;
    }

    /**
     * @return bool
     */
    public function isHighlighted()
    {
        return $this->isHighlighted;
    }

    /**
     * @param bool $isHighlighted
     */
    public function setIsHighlighted($isHighlighted)
    {
        $this->isHighlighted = $isHighlighted;
    }

    /**
     * @return bool
     */
    public function isFeatured()
    {
        return $this->isFeatured;
    }

    /**
     * @param bool $isFeatured
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = $isFeatured;
    }

    /**
     * @return string
     */
    public function getCurrentFee()
    {
        return $this->currentFee;
    }

    /**
     * @param string $currentFee
     */
    public function setCurrentFee($currentFee)
    {
        $this->currentFee = $currentFee;
    }

    /**
     * @return bool
     */
    public function isTax()
    {
        return $this->tax;
    }

    /**
     * @param bool $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return bool
     */
    public function isTaxIncluded()
    {
        return $this->taxIncluded;
    }

    /**
     * @param bool $taxIncluded
     */
    public function setTaxIncluded($taxIncluded)
    {
        $this->taxIncluded = $taxIncluded;
    }

    /**
     * @return bool
     */
    public function isBuyNowSale()
    {
        return $this->buyNowSale;
    }

    /**
     * @param bool $buyNowSale
     */
    public function setBuyNowSale($buyNowSale)
    {
        $this->buyNowSale = $buyNowSale;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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

