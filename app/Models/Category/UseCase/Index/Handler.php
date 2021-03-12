<?php


namespace App\Models\Category\UseCase\Index;


use App\Models\Category\Entity\Category;

class Handler
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $category = new Category();
        $category = $category->getAllCategories();
        return $category->toArray();
    }
}
