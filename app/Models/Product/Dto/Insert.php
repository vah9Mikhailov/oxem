<?php


namespace App\Models\Product\Dto;


final class Insert
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $externalId;

    /**
     * @var array
     */
    private $categoryIds;

    /**
     * @var array
     */
    private $storeIds;

    /**
     * @var array
     */
    private $qty;

    /**
     * InsertProduct constructor.
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $externalId
     * @param array $categoryIds
     * @param array $storeIds
     * @param array $qty
     */
    public function __construct(
        string $name,
        string $description,
        float $price,
        string $externalId,
        array $categoryIds,
        array $storeIds,
        array $qty
    )
    {

        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->externalId = $externalId;
        $this->categoryIds = $categoryIds;
        $this->storeIds = $storeIds;
        $this->qty = $qty;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @return array
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @return array
     */
    public function getStoreIds(): array
    {
        return $this->storeIds;
    }

    /**
     * @return array
     */
    public function getQty(): array
    {
        return $this->qty;
    }
}
