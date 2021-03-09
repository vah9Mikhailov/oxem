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
        $product = Product::query()->find($command->getId());
        if (is_null($product)) {
            throw new \DomainException("Товара с таким id={$command->getId()} не существует");
        } else {
            return $product->toArray();
        }
    }
}
