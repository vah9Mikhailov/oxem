<?php


namespace App\Models\Product\UseCase\Index;


use App\Models\Product\Entity\Sort;

class Command
{

    /**
     * @var Sort
     */
    private $sortType;

    /**
     * Command constructor.
     * @param string $s
     */
    public function __construct(string $s)
    {
        $this->sortType = new Sort($s);
    }

    /**
     * @return Sort
     */
    public function getSortType(): Sort
    {
        return $this->sortType;
    }
}
