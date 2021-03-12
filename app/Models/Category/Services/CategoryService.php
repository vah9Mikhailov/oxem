<?php


namespace App\Models\Category\Services;


use App\Models\Category\Entity\Category;

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
}
