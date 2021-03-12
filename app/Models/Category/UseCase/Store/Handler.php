<?php


namespace App\Models\Category\UseCase\Store;


use App\Models\Category\Entity\Category;
use App\Models\Category\Services\CategoryService;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        /*$categoryService = new CategoryService(new Category());
        $categoryService->checkParentIdForExistingId($command->getParentId());*/
        $category = new Category();
        $category = $category->createCategory($command);
        return $category->toArray();
    }
}
