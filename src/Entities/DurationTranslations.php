<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * DurationTranslations
 *
 * @ORM\Table(name="duration_translations")
 * @ORM\Entity
 */
class DurationTranslations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="duration_translation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $durationTranslationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Durations")
     * @ORM\JoinColumn(name="duration_id", referencedColumnName="duration_id")
     */
    private $durationId;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $language = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description = '';

    /**
     * @return int
     */
    public function getDurationTranslationId()
    {
        return $this->durationTranslationId;
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
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
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

