<?php


namespace App\Models\Product\UseCase\Index;


use App\Models\Product\Entity\Product;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        return (new Product())->getSortProduct($command->getSortType());
    }
}
