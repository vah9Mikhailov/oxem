<?php


namespace App\Dto;


final class UpdateProductDto
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
    private $categoryId;


    /**
     * UpdateProductDto constructor.
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $categories
     */
    public function __construct(
        string $name,
        string $description,
        float $price,
        string $categories
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->qty = $qty;
        $this->categoryId = $categories;
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
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
