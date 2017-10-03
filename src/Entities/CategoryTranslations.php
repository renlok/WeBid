<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryTranslations
 *
 * @ORM\Table(name="category_translations")
 * @ORM\Entity
 */
class CategoryTranslations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_translation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryTranslationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $categoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $language = '';

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=200, nullable=false)
     */
    private $categoryName = '';

    /**
     * @return int
     */
    public function getCategoryTranslationId()
    {
        return $this->categoryTranslationId;
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
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }


}

