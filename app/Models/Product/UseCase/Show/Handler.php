<?php


namespace App\Models\Product\UseCase\Show;


use App\Models\Product\Entity\Product;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        $product = new Product();
        $product = $product->showProduct($command);
        return $product->toArray();

    }
}
