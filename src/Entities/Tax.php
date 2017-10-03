<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tax
 *
 * @ORM\Table(name="tax")
 * @ORM\Entity
 */
class Tax
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tax_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $taxId;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_name", type="string", length=30, nullable=false)
     */
    private $taxName;

    /**
     * @var float
     *
     * @ORM\Column(name="tax_rate", type="float", precision=16, scale=2, nullable=false)
     */
    private $taxRate;

    /**
     * @var string
     *
     * @ORM\Column(name="countries_seller", type="text", length=65535, nullable=false)
     */
    private $countriesSeller;

    /**
     * @var string
     *
     * @ORM\Column(name="countries_buyer", type="text", length=65535, nullable=false)
     */
    private $countriesBuyer;

    /**
     * @var integer
     *
     * @ORM\Column(name="fee_tax", type="integer", nullable=false)
     */
    private $feeTax = '0';

    /**
     * @return int
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * @return string
     */
    public function getTaxName()
    {
        return $this->taxName;
    }

    /**
     * @param string $taxName
     */
    public function setTaxName($taxName)
    {
        $this->taxName = $taxName;
    }

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param float $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return string
     */
    public function getCountriesSeller()
    {
        return $this->countriesSeller;
    }

    /**
     * @param string $countriesSeller
     */
    public function setCountriesSeller($countriesSeller)
    {
        $this->countriesSeller = $countriesSeller;
    }

    /**
     * @return string
     */
    public function getCountriesBuyer()
    {
        return $this->countriesBuyer;
    }

    /**
     * @param string $countriesBuyer
     */
    public function setCountriesBuyer($countriesBuyer)
    {
        $this->countriesBuyer = $countriesBuyer;
    }

    /**
     * @return int
     */
    public function getFeeTax()
    {
        return $this->feeTax;
    }

    /**
     * @param int $feeTax
     */
    public function setFeeTax($feeTax)
    {
        $this->feeTax = $feeTax;
    }


}

