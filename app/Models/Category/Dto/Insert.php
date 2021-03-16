<?php


namespace App\Models\Category\Dto;


class Insert
{

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
     * InsertCategory constructor.
     * @param int $id
     * @param string $name
     * @param int $parentId
     * @param string $externalId
     */
    public function __construct(
        string $name,
        int $parentId,
        string $externalId
    )
    {
        $this->name = $name;
        $this->parentId = $parentId;
        $this->externalId = $externalId;
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
