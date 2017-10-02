<?php

namespace Src;

use Doctrine\ORM\Mapping as ORM;

/**
 * Durations
 *
 * @ORM\Table(name="durations")
 * @ORM\Entity
 */
class Durations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="duration_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $durationId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration_length", type="datetime", nullable=false)
     */
    private $durationLength = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=30, nullable=true)
     */
    private $description;

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
     * @return DateTime
     */
    public function getDurationLength()
    {
        return $this->durationLength;
    }

    /**
     * @param DateTime $durationLength
     */
    public function setDurationLength($durationLength)
    {
        $this->durationLength = $durationLength;
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


}

