<?php

namespace Src;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=50, nullable=false)
     */
    private $groupName = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="can_sell", type="boolean", nullable=false)
     */
    private $canSell = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="can_buy", type="boolean", nullable=false)
     */
    private $canBuy = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="no_fees", type="boolean", nullable=false)
     */
    private $noFees = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="count", type="boolean", nullable=false)
     */
    private $count = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="auto_join", type="boolean", nullable=false)
     */
    private $autoJoin = '0';

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return bool
     */
    public function isCanSell()
    {
        return $this->canSell;
    }

    /**
     * @param bool $canSell
     */
    public function setCanSell($canSell)
    {
        $this->canSell = $canSell;
    }

    /**
     * @return bool
     */
    public function isCanBuy()
    {
        return $this->canBuy;
    }

    /**
     * @param bool $canBuy
     */
    public function setCanBuy($canBuy)
    {
        $this->canBuy = $canBuy;
    }

    /**
     * @return bool
     */
    public function isNoFees()
    {
        return $this->noFees;
    }

    /**
     * @param bool $noFees
     */
    public function setNoFees($noFees)
    {
        $this->noFees = $noFees;
    }

    /**
     * @return bool
     */
    public function isCount()
    {
        return $this->count;
    }

    /**
     * @param bool $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return bool
     */
    public function isAutoJoin()
    {
        return $this->autoJoin;
    }

    /**
     * @param bool $autoJoin
     */
    public function setAutoJoin($autoJoin)
    {
        $this->autoJoin = $autoJoin;
    }


}

