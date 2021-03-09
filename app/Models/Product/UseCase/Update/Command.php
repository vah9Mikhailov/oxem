<?php


namespace App\Models\Product\UseCase\Update;


use App\Models\Product\Dto\UpdateProduct;
use DomainException;
use Webmozart\Assert\Assert;

class Command
{
    /**
     * @var int
     */
    private $id;

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
     * Command constructor.
     * @param UpdateProduct $dto
     */
    public function __construct(UpdateProduct $dto)
    {
        $this->validate($dto);
        $this->id = $dto->getId();
        $this->name = $dto->getName();
        $this->description = $dto->getDescription();
        $this->price = $dto->getPrice();
        $this->externalId = $dto->getExternalId();
        $this->categoryIds = $dto->getCategoryIds();
        $this->storeIds = $dto->getStoreIds();
        $this->qty = $dto->getQty();
    }

    /**
     * @param UpdateProduct $dto
     */
    public function validate(UpdateProduct $dto)
    {
        Assert::stringNotEmpty($dto->getName(), "Поле name должно быть строкой!");
        Assert::stringNotEmpty($dto->getDescription(), "Поле description должно быть строкой!");
        Assert::float($dto->getPrice(), "Поле price должно быть числом!");
        Assert::stringNotEmpty($dto->getExternalId(), "Поле external_id должно быть строкой!");
        if (empty($dto->getCategoryIds())) {
            throw new DomainException('Category_id пуст');
        }

        if (empty($dto->getStoreIds())) {
            throw new DomainException('Store_id пуст');
        }

        if (empty($dto->getQty())) {
            throw new DomainException('Quantity пуст');
        }

        if (count($dto->getStoreIds()) !== count($dto->getQty())) {
            throw new DomainException('Количество складов не соответствует числу количества товаров');
        }

        if ($dto->getId() === 0) {
            throw new DomainException('Некорректный id');
        }

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
