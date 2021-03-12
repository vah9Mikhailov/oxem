<?php


namespace App\Models\Category\UseCase\Update;


use App\Models\Category\Dto\UpdateCategory;
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
     * @var int
     */
    private $parentId;

    /**
     * @var string
     */
    private $externalId;

    /**
     * Command constructor.
     * @param UpdateCategory $dto
     */
    public function __construct(UpdateCategory $dto)
    {
        $this->validate($dto);
        $this->id = $dto->getId();
        $this->name = $dto->getName();
        $this->parentId = $dto->getParentId();
        $this->externalId = $dto->getExternalId();
    }

    /**
     * @param UpdateCategory $dto
     */
    public function validate(UpdateCategory $dto)
    {
        Assert::stringNotEmpty($dto->getName(), 'Поле name должно быть строкой');
        Assert::greaterThan($dto->getParentId(),1, 'Поле parent_id должно быть числом');
        Assert::stringNotEmpty($dto->getExternalId(), "Поле external_id должно быть строкой");

        if ($dto->getId() === 0) {
            throw new \DomainException('Некорректный id');
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
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }
}
