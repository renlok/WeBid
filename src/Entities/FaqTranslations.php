<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * FaqTranslations
 *
 * @ORM\Table(name="faq_translations")
 * @ORM\Entity
 */
class FaqTranslations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="faq_translation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $faqTranslationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="faq_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Faqs")
     * @ORM\JoinColumn(name="faq_id", referencedColumnName="faq_id")
     */
    private $faqId;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=200, nullable=false)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text", length=65535, nullable=false)
     */
    private $answer;

    /**
     * @return int
     */
    public function getFaqTranslationId()
    {
        return $this->faqTranslationId;
    }

    /**
     * @return int
     */
    public function getFaqId()
    {
        return $this->faqId;
    }

    /**
     * @param int $faqId
     */
    public function setFaqId($faqId)
    {
        $this->faqId = $faqId;
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


}

