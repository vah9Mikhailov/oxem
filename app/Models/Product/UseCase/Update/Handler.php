<?php


namespace App\Models\Product\UseCase\Update;


use App\Models\Category;
use App\Models\Product\Entity\Product;
use App\Models\Product\Services\ProductService;
use App\Models\Store;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command)
    {
        $product = new Product();
        $product = $product->updateProduct($command);
        $productService = new ProductService(new Product(),new Category(),new Store());
        $ids = $productService->checkCategoriesForExisting($command->getCategoryIds());
        $ides = $productService->checkStoresForExisting($command->getStoreIds());
        $productService->addStoresToNewProducts($product,$ides,$command->getQty());
        $productService->addCategoriesToNewProducts($product,$ids);
        return $product->toArray();
    }
}
