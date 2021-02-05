<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GetSalesOrderResponse
{
    /**
     * @var string|null
     */
    private $errorName;

    /**
     * @SerializedName("message")
     * @var string|null
     */
    private $errorMessage;

    /**
     * @var string
     */
    private $result;

    /**
     * @var SalesOrder|null
     * @SerializedName("record")
     */
    private $salesOrder;

    public function isSuccessful(): bool
    {
        return $this->result === 'ok';
    }

    /**
     * @param string|null $errorName
     */
    public function setErrorName(?string $errorName): void
    {
        $this->errorName = $errorName;
    }

    /**
     * @param string|null $errorMessage
     */
    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }


    /**
     * @return string|null
     */
    public function getErrorName(): ?string
    {
        return $this->errorName;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @return SalesOrder|null
     */
    public function getSalesOrder(): ?SalesOrder
    {
        return $this->salesOrder;
    }

    /**
     * @param SalesOrder|null $salesOrder
     */
    public function setSalesOrder(?SalesOrder $salesOrder): void
    {
        $this->salesOrder = $salesOrder;
    }


}