<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * FaqCategoryTranslations
 *
 * @ORM\Table(name="faq_category_translations")
 * @ORM\Entity
 */
class FaqCategoryTranslations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="faq_category_translation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $faqCategoryTranslationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="faq_category_id", type="integer", nullable=false)
     */
    private $faqCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false)
     */
    private $categoryName;

    /**
     * @return int
     */
    public function getFaqCategoryTranslationId()
    {
        return $this->faqCategoryTranslationId;
    }

    /**
     * @param int $faqCategoryTranslationId
     */
    public function setFaqCategoryTranslationId($faqCategoryTranslationId)
    {
        $this->faqCategoryTranslationId = $faqCategoryTranslationId;
    }

    /**
     * @return int
     */
    public function getFaqCategoryId()
    {
        return $this->faqCategoryId;
    }

    /**
     * @param int $faqCategoryId
     */
    public function setFaqCategoryId($faqCategoryId)
    {
        $this->faqCategoryId = $faqCategoryId;
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

