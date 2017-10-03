<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGateways
 *
 * @ORM\Table(name="user_gateways")
 * @ORM\Entity
 */
class UserGateways
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_gateway_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userGatewayId;

    /**
     * @var integer
     *
     * @ORM\Column(name="gateway_id", type="integer", nullable=false)
     */
    private $gatewayId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     */
    private $password = '';

    /**
     * @return int
     */
    public function getUserGatewayId()
    {
        return $this->userGatewayId;
    }

    /**
     * @param int $userGatewayId
     */
    public function setUserGatewayId($userGatewayId)
    {
        $this->userGatewayId = $userGatewayId;
    }

    /**
     * @return int
     */
    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    /**
     * @param int $gatewayId
     */
    public function setGatewayId($gatewayId)
    {
        $this->gatewayId = $gatewayId;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


}

