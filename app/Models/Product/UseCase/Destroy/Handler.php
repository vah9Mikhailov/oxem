<?php


namespace App\Models\Product\UseCase\Destroy;


use App\Models\Category\Entity\Category;
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
    public function handle(Command $command): array
    {
        $product = new Product();
        $product = $product->deleteProduct($command);
        $productService = new ProductService(new Product(), new Category(), new Store());
        $productService->deleteIdProductForExistingOnCategories($command->getId());
        $productService->deleteIdProductForExistingOnStores($command->getId());
        return $product->toArray();
    }


}
