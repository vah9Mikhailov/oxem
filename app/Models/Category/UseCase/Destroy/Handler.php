<?php


namespace App\Models\Category\UseCase\Destroy;


use App\Models\Category\Entity\Category;
use Exception;

class Handler
{
    /**
     * @param Command $command
     * @return array
     * @throws Exception
     */
    public function handle(Command $command): array
    {
        $category = new Category();
        $category = $category->deleteCategory($command);
        return $category->toArray();
    }
}
