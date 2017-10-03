<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faqs
 *
 * @ORM\Table(name="faqs")
 * @ORM\Entity
 */
class Faqs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="faq_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $faqId;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=200, nullable=false)
     */
    private $question = '';

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text", length=65535, nullable=false)
     */
    private $answer;

    /**
     * @var integer
     *
     * @ORM\Column(name="faq_category_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="FaqCategories")
     * @ORM\JoinColumn(name="faq_category_id", referencedColumnName="faq_category_id")
     */
    private $faqCategoryId = '0';

    /**
     * @return int
     */
    public function getFaqId()
    {
        return $this->faqId;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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


}

