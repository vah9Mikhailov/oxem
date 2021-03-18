<?php


namespace App\Models\Category\UseCase\Update;


use App\Models\Category\Dto\Update;
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
     * @param Update $dto
     */
    public function __construct(Update $dto)
    {
        $this->validate($dto);
        $this->id = $dto->getId();
        $this->name = $dto->getName();
        $this->parentId = $dto->getParentId();
        $this->externalId = $dto->getExternalId();
    }

    /**
     * @param Update $dto
     */
    public function validate(Update $dto)
    {
        Assert::nullOrString($dto->getName(), 'Поле name должно быть строкой');
        Assert::nullOrGreaterThan($dto->getParentId(), 1, 'Поле parent_id должно быть числом');
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getParentId(): ?int
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
