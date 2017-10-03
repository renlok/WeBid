<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistics
 *
 * @ORM\Table(name="statistics")
 * @ORM\Entity
 */
class Statistics
{
    /**
     * @var integer
     *
     * @ORM\Column(name="statistics_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $statisticsId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="pageviews", type="integer", nullable=false)
     */
    private $pageviews = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="uniquevisitors", type="integer", nullable=false)
     */
    private $uniquevisitors = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="usersessions", type="integer", nullable=false)
     */
    private $usersessions = '0';

    /**
     * @return int
     */
    public function getStatisticsId()
    {
        return $this->statisticsId;
    }

    /**
     * @param int $statisticsId
     */
    public function setStatisticsId($statisticsId)
    {
        $this->statisticsId = $statisticsId;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getPageviews()
    {
        return $this->pageviews;
    }

    /**
     * @param int $pageviews
     */
    public function setPageviews($pageviews)
    {
        $this->pageviews = $pageviews;
    }

    /**
     * @return int
     */
    public function getUniquevisitors()
    {
        return $this->uniquevisitors;
    }

    /**
     * @param int $uniquevisitors
     */
    public function setUniquevisitors($uniquevisitors)
    {
        $this->uniquevisitors = $uniquevisitors;
    }

    /**
     * @return int
     */
    public function getUsersessions()
    {
        return $this->usersessions;
    }

    /**
     * @param int $usersessions
     */
    public function setUsersessions($usersessions)
    {
        $this->usersessions = $usersessions;
    }


}

