<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedbackLevels
 *
 * @ORM\Table(name="feedback_levels")
 * @ORM\Entity
 */
class FeedbackLevels
{
    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_level_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $feedbackLevelId;

    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_level", type="integer", nullable=false)
     */
    private $feedbackLevel = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=30, nullable=false)
     */
    private $icon = '';

    /**
     * @return int
     */
    public function getFeedbackLevelId()
    {
        return $this->feedbackLevelId;
    }

    /**
     * @param int $feedbackLevelId
     */
    public function setFeedbackLevelId($feedbackLevelId)
    {
        $this->feedbackLevelId = $feedbackLevelId;
    }

    /**
     * @return int
     */
    public function getFeedbackLevel()
    {
        return $this->feedbackLevel;
    }

    /**
     * @param int $feedbackLevel
     */
    public function setFeedbackLevel($feedbackLevel)
    {
        $this->feedbackLevel = $feedbackLevel;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }


}

