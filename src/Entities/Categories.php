<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories", indexes={@ORM\Index(name="left_id", columns={"left_id", "right_id", "level"})})
 * @ORM\Entity
 */
class Categories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="category_id")
     */
    private $parentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="left_id", type="integer", nullable=false)
     * @ORM\OneToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="left_id", referencedColumnName="category_id")
     */
    private $leftId;

    /**
     * @var integer
     *
     * @ORM\Column(name="right_id", type="integer", nullable=false)
     * @ORM\OneToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="right_id", referencedColumnName="category_id")
     */
    private $rightId;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="text", length=255, nullable=false)
     */
    private $categoryName;

    /**
     * @var integer
     *
     * @ORM\Column(name="sub_counter", type="integer", nullable=false)
     */
    private $subCounter = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="counter", type="integer", nullable=false)
     */
    private $counter = '0';

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getLeftId()
    {
        return $this->leftId;
    }

    /**
     * @param int $leftId
     */
    public function setLeftId($leftId)
    {
        $this->leftId = $leftId;
    }

    /**
     * @return int
     */
    public function getRightId()
    {
        return $this->rightId;
    }

    /**
     * @param int $rightId
     */
    public function setRightId($rightId)
    {
        $this->rightId = $rightId;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
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

    /**
     * @return int
     */
    public function getSubCounter()
    {
        return $this->subCounter;
    }

    /**
     * @param int $subCounter
     */
    public function setSubCounter($subCounter)
    {
        $this->subCounter = $subCounter;
    }

    /**
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param int $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }


}

