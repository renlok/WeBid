<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * CountryTranslations
 *
 * @ORM\Table(name="country_translations")
 * @ORM\Entity
 */
class CountryTranslations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="country_translation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $countryTranslationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Countries")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="country_id")
     */
    private $countryId;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $language = '';

    /**
     * @var string
     *
     * @ORM\Column(name="country_name", type="string", length=255, nullable=false)
     */
    private $countryName = '';

    /**
     * @return int
     */
    public function getCountryTranslationId()
    {
        return $this->countryTranslationId;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
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
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    }


}

