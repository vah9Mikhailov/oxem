<?php


namespace App\Models\Category\UseCase\Store;


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
        $category = $category->create($command);
        return $category->toArray();
    }
}
