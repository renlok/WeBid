<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Increments
 *
 * @ORM\Table(name="increments")
 * @ORM\Entity
 */
class Increments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="increment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $incrementId;

    /**
     * @var string
     *
     * @ORM\Column(name="low", type="decimal", precision=16, scale=2, nullable=true)
     */
    private $low = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="high", type="decimal", precision=16, scale=2, nullable=true)
     */
    private $high = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="increment", type="decimal", precision=16, scale=2, nullable=true)
     */
    private $increment = '0.00';

    /**
     * @return int
     */
    public function getIncrementId()
    {
        return $this->incrementId;
    }

    /**
     * @return string
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * @param string $low
     */
    public function setLow($low)
    {
        $this->low = $low;
    }

    /**
     * @return string
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * @param string $high
     */
    public function setHigh($high)
    {
        $this->high = $high;
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


}

