<?php


namespace App\Models\Product\Entity;


class Sort
{
    public const PRICE_UP = "priceup";

    public const PRICE_DOWN = "pricedown";

    public const DATA_UP = "dataup";

    public const DATA_DOWN = "datadown";

    public const DEFAULT = "default";

    /**
     * @var string[]
     */
    private $types = [
        self::PRICE_DOWN, self::PRICE_UP, self::DATA_UP, self::DATA_DOWN, self::DEFAULT,
    ];

    /**
     * @var string
     */
    private $current;

    /**
     * Sort constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $types = array_flip($this->types);
        if (isset($types[$type])) {
            $this->current = $type;
        } else {
            throw new \DomainException('Не существует типа сортировки');
        }
    }


    /**
     * @return string
     */
    public function getCurrent(): string
    {
        return $this->current;
    }
}
