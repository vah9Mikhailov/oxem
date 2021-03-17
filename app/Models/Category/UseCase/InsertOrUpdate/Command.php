<?php


namespace App\Models\Category\UseCase\InsertOrUpdate;


use App\Models\Category\Dto\Insert;
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

    public function __construct(Insert $dto)
    {
        $this->validate($dto);
        $this->name = $dto->getName();
        $this->parentId = $dto->getParentId();
        $this->externalId = $dto->getExternalId();
    }

    private function validate(Insert $dto)
    {
        Assert::stringNotEmpty($dto->getName(), 'Поле name должно быть строкой');
        Assert::greaterThan($dto->getParentId(),1,'Поле parent_id не может быть строкой или 0');
        Assert::stringNotEmpty($dto->getExternalId(), "Поле external_id должно быть строкой");
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}