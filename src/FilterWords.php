<?php

namespace Src;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilterWords
 *
 * @ORM\Table(name="filter_words")
 * @ORM\Entity
 */
class FilterWords
{
    /**
     * @var integer
     *
     * @ORM\Column(name="filter_word_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $filterWordId;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=255, nullable=false)
     */
    private $word = '';

    /**
     * @return int
     */
    public function getFilterWordId()
    {
        return $this->filterWordId;
    }

    /**
     * @param int $filterWordId
     */
    public function setFilterWordId($filterWordId)
    {
        $this->filterWordId = $filterWordId;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }


}

