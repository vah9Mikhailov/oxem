<?php


namespace App\Models\Product\UseCase\Destroy;


use App\Models\Category;
use App\Models\Product\Entity\Product;
use App\Models\Product\Services\ProductService;
use App\Models\Store;

class Handler
{

    /**
     * @param Command $command
     * @return array
     * @throws \Exception
     */
    public function handle(Command $command):array
    {
        $product = Product::query()->find($command->getId());
        if (is_null($product)) {
            throw new \DomainException("Продукта с id = {$command->getId()} не существует ");
        } else {
            $product->delete();
            $productService = new ProductService(new Product(),new Category(),new Store());
            $productService->deleteIdProductForExistingOnCategories($command->getId());
            $productService->deleteIdProductForExistingOnStores($command->getId());
            return $product->toArray();
        }
    }


}
