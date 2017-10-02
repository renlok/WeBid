<?php

namespace Src;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentOptions
 *
 * @ORM\Table(name="payment_options")
 * @ORM\Entity
 */
class PaymentOptions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="payment_option_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paymentOptionId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="displayname", type="string", length=50, nullable=false)
     */
    private $displayname = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_gateway", type="boolean", nullable=false)
     */
    private $isGateway = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="gateway_admin_address", type="string", length=50, nullable=false)
     */
    private $gatewayAdminAddress = '';

    /**
     * @var string
     *
     * @ORM\Column(name="gateway_admin_password", type="string", length=50, nullable=false)
     */
    private $gatewayAdminPassword = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="gateway_required", type="boolean", nullable=false)
     */
    private $gatewayRequired = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="gateway_active", type="boolean", nullable=false)
     */
    private $gatewayActive = '0';

    /**
     * @return int
     */
    public function getPaymentOptionId()
    {
        return $this->paymentOptionId;
    }

    /**
     * @param int $paymentOptionId
     */
    public function setPaymentOptionId($paymentOptionId)
    {
        $this->paymentOptionId = $paymentOptionId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * @param string $displayname
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;
    }

    /**
     * @return bool
     */
    public function isGateway()
    {
        return $this->isGateway;
    }

    /**
     * @param bool $isGateway
     */
    public function setIsGateway($isGateway)
    {
        $this->isGateway = $isGateway;
    }

    /**
     * @return string
     */
    public function getGatewayAdminAddress()
    {
        return $this->gatewayAdminAddress;
    }

    /**
     * @param string $gatewayAdminAddress
     */
    public function setGatewayAdminAddress($gatewayAdminAddress)
    {
        $this->gatewayAdminAddress = $gatewayAdminAddress;
    }

    /**
     * @return string
     */
    public function getGatewayAdminPassword()
    {
        return $this->gatewayAdminPassword;
    }

    /**
     * @param string $gatewayAdminPassword
     */
    public function setGatewayAdminPassword($gatewayAdminPassword)
    {
        $this->gatewayAdminPassword = $gatewayAdminPassword;
    }

    /**
     * @return bool
     */
    public function isGatewayRequired()
    {
        return $this->gatewayRequired;
    }

    /**
     * @param bool $gatewayRequired
     */
    public function setGatewayRequired($gatewayRequired)
    {
        $this->gatewayRequired = $gatewayRequired;
    }

    /**
     * @return bool
     */
    public function isGatewayActive()
    {
        return $this->gatewayActive;
    }

    /**
     * @param bool $gatewayActive
     */
    public function setGatewayActive($gatewayActive)
    {
        $this->gatewayActive = $gatewayActive;
    }


}

