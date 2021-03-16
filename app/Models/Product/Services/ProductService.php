<?php


namespace App\Models\Product\Services;


use App\Models\Category\Entity\Category;
use App\Models\Product\Entity\Product;
use App\Models\Store\Entity\Store;
use DateTime;
use DomainException;
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
    public function addCategoriesToNewProducts(Product $product, ?array $categories): bool
    {
        $insertData = [];
        if (!is_null($categories)) {
            foreach ($categories as $v) {
                if ((int)$v !== 0) {
                    $insertData[] = [
                        'product_id' => $product->id,
                        'category_id' => (int)$v,
                        'created_at' => (new DateTime())->format('Y-m-d h:i:s'),
                        'updated_at' => (new DateTime())->format('Y-m-d h:i:s'),
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            foreach ($insertData as $k => $v) {
                DB::table('category_product')
                    ->updateOrInsert(['product_id' => $v['product_id'],
                        'category_id' => $v['category_id'],
                    ], [
                        'category_id' => $v['category_id'],
                        'created_at' => $v['created_at'],
                        'updated_at' => $v['updated_at'],
                    ]);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $ids
     * @return array
     */
    public function checkCategoriesForExisting(?array $ids): ?array
    {
        $collection = $this->category->query()->findMany($ids);
        if (!is_null($ids)) {
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
        }
        return $ids;
    }

    /**
     * @param Product $product
     * @param array $stores
     * @param array $qtys
     * @return bool
     */
    public function addStoresToNewProducts(Product $product, ?array $stores, ?array $qtys): bool
    {
        $insertData = [];
        if (!is_null($stores)) {
            foreach ($stores as $k => $v) {
                if (isset($qtys[$k]) && (int)$v !== 0) {
                    $insertData[] = [
                        'store_id' => (int)$v,
                        'product_id' => $product->id,
                        'quantity' => $qtys[$k],
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            foreach ($insertData as $k => $v) {
                DB::table('product_store')
                    ->updateOrInsert([
                        'store_id' => $v['store_id'],
                        'product_id' => $v['product_id'],
                    ], [
                        'quantity' => $v['quantity']
                    ]);
            }
            return true;
        } else {
            return false;
        }
    }

    public function checkStoresForExisting(?array $ids): ?array
    {
        $collection = $this->store->query()->findMany($ids);
        if (!is_null($ids)) {
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
        }
        return $ids;
    }

    /**
     * @param int $id
     */
    public function deleteIdProductForExistingOnCategories(int $id)
    {
        DB::table('category_product')->where('product_id', '=', "$id")->delete();
    }

    /**
     * @param int $id
     */
    public function deleteIdProductForExistingOnStores(int $id)
    {
        DB::table('product_store')->where('product_id', '=', "$id")->delete();
    }
}
