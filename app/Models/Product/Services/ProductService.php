<?php


namespace App\Models\Product\Services;


use App\Models\Category;
use App\Models\Product\Entity\Product;
use App\Models\Store;
use DateTime;
use Illuminate\Support\Facades\DB;

final class ProductService
{
    /**
     * @var Product
     */
    private $product;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var Store
     */
    private $store;

    /**
     * ProductService constructor.
     * @param Product $product
     * @param Category $category
     * @param Store $store
     */
    public function __construct(Product $product, Category $category, Store $store)
    {
        $this->product = $product;
        $this->category = $category;
        $this->store = $store;
    }

    /**
     * @param Product $product
     * @param array $categories
     * @return bool
     */
    public function addCategoriesToNewProducts(Product $product, array $categories): bool
    {
        $insertData = [];

        foreach ($categories as $v) {
            $value = (int)$v;
            if ($value !== 0) {
                $insertData[] = [
                    'product_id' => $product->id,
                    'category_id' => $value,
                    'created_at' => (new DateTime())->format('Y-m-d h:i:s'),
                    'updated_at' => (new DateTime())->format('Y-m-d h:i:s'),
                ];
            }
        }
        if (!empty($insertData)) {
            DB::table('category_product')
                ->insert($insertData);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $ids
     * @return array
     */
    public function checkCategoriesForExisting(array $ids): array
    {
        $collection = $this->category->query()->findMany($ids);
        foreach ($ids as $k => $v) {
            $isset = false;
            foreach ($collection as $value) {
                if ($value->id == $v) {
                    $isset = true;
                    break;
                }
            }
            if (!$isset) {
                unset($ids[$k]);
            }
        }
        if (empty($ids)){
            throw new \DomainException('Таких категорий не существует');
        } else{
            return $ids;
        }

    }

    /**
     * @param Product $product
     * @param array $stores
     * @param array $qtys
     * @return bool
     */
    public function addStoresToNewProducts(Product $product, array $stores,array $qtys): bool
    {
        $insertData = [];

        foreach ($stores as $k => $v) {
            $value = (int)$v;
            foreach ($qtys as $key => $qty){
                if ($value !== 0 && $k === $key) {
                    $insertData[] = [
                        'store_id' => $value,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                ];
                }
            }

        }
        if (!empty($insertData)) {
            DB::table('product_store')
                ->insert($insertData);
            return true;
        } else {
            return false;
        }
    }
    public function checkStoresForExisting(array $ids): array
    {
        $collection = $this->store->query()->findMany($ids);
        foreach ($ids as $k => $v) {
            $isset = false;
            foreach ($collection as $value) {
                if ($value->id == $v) {
                    $isset = true;
                    break;
                }
            }
            if (!$isset) {
                unset($ids[$k]);
            }
        }
        if (empty($ids)){
            throw new \DomainException('Таких складов не существует');
        } else{
            return $ids;
        }
    }

}
