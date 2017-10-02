<?php

namespace Src;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fees
 *
 * @ORM\Table(name="fees")
 * @ORM\Entity
 */
class Fees
{
    /**
     * @var integer
     *
     * @ORM\Column(name="fee_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $feeId;

    /**
     * @var string
     *
     * @ORM\Column(name="fee_from", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $feeFrom = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="fee_to", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $feeTo = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="fee_type", type="string", length=25, nullable=false)
     */
    private $feeType = 'flat';

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $value = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15, nullable=false)
     */
    private $type;

    /**
     * @return int
     */
    public function getFeeId()
    {
        return $this->feeId;
    }

    /**
     * @param int $feeId
     */
    public function setFeeId($feeId)
    {
        $this->feeId = $feeId;
    }

    /**
     * @return string
     */
    public function getFeeFrom()
    {
        return $this->feeFrom;
    }

    /**
     * @param string $feeFrom
     */
    public function setFeeFrom($feeFrom)
    {
        $this->feeFrom = $feeFrom;
    }

    /**
     * @return string
     */
    public function getFeeTo()
    {
        return $this->feeTo;
    }

    /**
     * @param string $feeTo
     */
    public function setFeeTo($feeTo)
    {
        $this->feeTo = $feeTo;
    }

    /**
     * @return string
     */
    public function getFeeType()
    {
        return $this->feeType;
    }

    /**
     * @param string $feeType
     */
    public function setFeeType($feeType)
    {
        $this->feeType = $feeType;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

