<?php


namespace App\Models\Category\Services;


use App\Models\Category\Entity\Category;
use App\Models\Category\UseCase\Store\Command;

class CategoryService
{
    /**
     * @var Category
     */
    private $category;

    /**
     * CategoryService constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        $category = new Category();
        $category = $category->updateOrInsert($command);
        return $category->toArray();
    }
}
