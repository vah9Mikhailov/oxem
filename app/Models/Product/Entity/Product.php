<?php

namespace App\Models\Product\Entity;

use App\Dto\UpdateProduct;
use App\Models\Category;
use App\Models\Product\UseCase\Destroy\Command as DestroyCommand;
use App\Models\Product\UseCase\Index\Index;
use App\Models\Product\UseCase\Show\Command as ShowCommand;
use App\Models\Product\UseCase\Store\Command;
use App\Models\Product\UseCase\Update\Command as UpdateCommand;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'external_id'];

    /**
     * @var integer
     */


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    /**
     * @param UpdateProduct $dto
     */
    public function updateProductInfo(UpdateProduct $dto)
    {
        if (!empty($this->id)) {
            $this->name = $dto->getName();
            $this->description = $dto->getDescription();
            $this->price = $dto->getPrice();
            if ($this->save()) {
                $this->addProductsToCategory($this->id, $dto->getCategoryId());
            }
        }
    }

    /**
     * @param int $productId
     * @param string $categories
     * @return bool
     */
    private function addProductsToCategory(int $productId, string $categories)
    {
        $ids = explode(",", $categories);
        $ids = array_flip(array_flip($ids));
        $currentCategories = array_flip($this->getProductCategories($productId));
        foreach ($ids as $key => $id) {
            if (isset($currentCategories[$id])) {
                unset($ids[$key]);
            }
        }

        if ($ids) {
            $this->assignCategoryToProduct($ids, $productId);
        }
        return true;
    }

    /**
     * @param $productId
     * @return array
     */
    private function getProductCategories($productId): array
    {
        $result = [];

        $results = DB::table('category_product')
            ->select(["id", "product_id", "category_id"])
            ->where(["product_id" => $productId])
            ->get();


        foreach ($results as $value) {
            $result[$value->id] = $value->category_id;
        }

        return $result;
    }

    /**
     * @param array $ids
     * @param int $productId
     * @return bool
     */
    private function assignCategoryToProduct(array $ids, int $productId)
    {
        foreach ($ids as $id) {
            DB::table("category_product")->insert([
                "product_id" => $productId,
                "category_id" => $id,
                "created_at" => (new \DateTime())->format("Y-m-d h:i:s"),
                "updated_at" => (new \DateTime())->format("Y-m-d h:i:s"),
            ]);
        }
        return true;
    }

    /**
     * @param Sort $sortType
     * @param int $count
     * @return array
     */
    public function getSortProduct(Sort $sortType, int $count = 50): array
    {
        switch ($sortType->getCurrent()) {
            case Sort::DATA_UP:
                return $this->query()->orderBy('created_at', 'asc')->paginate($count)->toArray();
            case Sort::DATA_DOWN:
                return $this->query()->orderBy('created_at', 'desc')->paginate($count)->toArray();
            case Sort::PRICE_UP:
                return $this->query()->orderBy('price', 'asc')->paginate($count)->toArray();
            case Sort::PRICE_DOWN:
                return $this->query()->orderBy('price', 'desc')->paginate($count)->toArray();
            case Sort::DEFAULT:
                return $this->query()->paginate($count)->toArray();
        }
    }

    /**
     * @param Command $command
     * @return $this
     */
    public function createProduct(Command $command): Product
    {
        $this->name = $command->getName();
        $this->description = $command->getDescription();
        $this->price = $command->getPrice();
        $this->external_id = $command->getExternalId();

        if ($this->save()) {
            return $this;
        } else {
            throw new \DomainException('Возникла ошибка при сохранении товара');
        }
    }

    /**
     * @param ShowCommand $command
     * @return Product
     */
    public function showProduct(ShowCommand $command): Product
    {
        /**
         * @var $product Product
         */
        $product = $this->query()->find($command->getId());
        if (is_null($product)) {
            throw new \DomainException("Товара с id={$command->getId()} не существует");
        }
        return $product;
    }

    /**
     * @param UpdateCommand $command
     * @return Product
     */
    public function updateProduct(UpdateCommand $command): Product
    {
        /**
         * @var $product Product
         */
        $product = $this->query()->find($command->getId());
        if (!is_null($product)) {
            $product->name = $command->getName();
            $product->description = $command->getDescription();
            $product->price = $command->getPrice();
            $product->external_id = $command->getExternalId();
            $product->update();
        } else {
            throw new \DomainException('Товар не найден');
        }
        return $product;
    }

    /**
     * @param DestroyCommand $command
     * @return Product
     * @throws \Exception
     */
    public function deleteProduct(DestroyCommand $command): Product
    {
        /**
         * @var $product Product
         */
        $product = $this->query()->find($command->getId());
        if (is_null($product)) {
            throw new \DomainException("Продукта с id = {$command->getId()} не существует ");
        } else {
            $product->delete();
            return $product;
        }
    }


}
