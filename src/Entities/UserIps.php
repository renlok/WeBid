<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserIps
 *
 * @ORM\Table(name="user_ips")
 * @ORM\Entity
 */
class UserIps
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_ip_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userIpId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private $ip;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_blocked", type="boolean", nullable=false)
     */
    private $isBlocked = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="recorded_action", type="string", length=255, nullable=true)
     */
    private $recordedAction = 'register';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getUserIpId()
    {
        return $this->userIpId;
    }

    /**
     * @param int $userIpId
     */
    public function setUserIpId($userIpId)
    {
        $this->userIpId = $userIpId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * @param bool $isBlocked
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;
    }

    /**
     * @return string
     */
    public function getRecordedAction()
    {
        return $this->recordedAction;
    }

    /**
     * @param string $recordedAction
     */
    public function setRecordedAction($recordedAction)
    {
        $this->recordedAction = $recordedAction;
    }

    /**
     * @return DateTime
     */
    public function getcreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setcreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}

