<?php


namespace App\Models\Category\UseCase\Show;


use App\Models\Category\Entity\Category;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        $category = new Category();
        $category = $category->getProductWithCategories($command);
        return $category;
    }
}
