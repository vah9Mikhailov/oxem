<?php


namespace App\Models\Category\Dto;


class UpdateCategory
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
     * UpdateCategory constructor.
     * @param int $id
     * @param string $name
     * @param int $parentId
     * @param string $externalId
     */
    public function __construct(
        int $id,
        string $name,
        int $parentId,
        string $externalId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->externalId = $externalId;
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
