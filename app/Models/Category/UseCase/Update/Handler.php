<?php


namespace App\Models\Category\UseCase\Update;


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
        $category = $category->updateCategory($command);
        return $category->toArray();
    }
}
