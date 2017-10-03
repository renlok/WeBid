<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * FaqCategories
 *
 * @ORM\Table(name="faq_categories")
 * @ORM\Entity
 */
class FaqCategories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="faq_category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $faqCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=200, nullable=false)
     */
    private $categoryName = '';

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

