<?php


namespace App\Models\Product\UseCase\InsertOrUpdate;


use App\Models\Category\Entity\Category;
use App\Models\Product\Entity\Product;
use App\Models\Product\Services\ProductService;
use App\Models\Store\Entity\Store;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        $product = new Product();
        $product = $product->insertOrUpdate($command);
        $productService = new ProductService(new Product(),new Category(),new Store());
        $ids = $productService->checkCategoriesForExisting($command->getCategoryIds());
        $ides = $productService->checkStoresForExisting($command->getStoreIds());
        $productService->addCategoriesToNewProducts($product,$ids);
        $productService->addStoresToNewProducts($product,$ides, $command->getQty());
        return $product->toArray();
    }
}