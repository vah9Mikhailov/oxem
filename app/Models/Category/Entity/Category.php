<?php

namespace App\Models\Category\Entity;


use App\Models\Category\UseCase\Destroy\Command as DestroyCommand;
use App\Models\Category\UseCase\Show\Command as ShowCommand;
use App\Models\Category\UseCase\Store\Command;
use App\Models\Category\UseCase\Update\Command as UpdateCommand;
use App\Models\Product\Entity\Product;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'parent_id', 'external_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAllCategories()
    {
        $category = $this->query()->get();
        if (is_null($category)) {
            throw new \DomainException('Категорий не существует');
        }
        return $category;
    }

    /**
     * @param Command $command
     * @return $this
     */
    public function createCategory(Command $command): Category
    {
        $this->name = $command->getName();
        $this->parent_id = $this->checkParentIdForExistingId($command->getParentId());
        $this->external_id = $command->getExternalId();

        if ($this->save()) {
            return $this;
        } else {
            throw new \DomainException('Возникла ошибка при сохранении категории');
        }
    }

    /**
     * @param int $id
     * @return int
     */
    private function checkParentIdForExistingId(int $id): int
    {
        $result = Category::query()->find($id);
        if (is_null($result)) {
            throw new \DomainException("Категории с id = {$id} не существует");
        } elseif ($result->id == $id) {
            return $id;
        }
    }

    /**
     * @param ShowCommand $command
     * @return array
     */
    public function getProductWithCategories(ShowCommand $command): array
    {
        /**
         * @var $products Product
         */
        $category = $this->query()->find($command->getId());
        if (is_null($category)) {
            throw new \DomainException("Категории с id = {$command->getId()} не существует");
        } else {
            $products = DB::table('products')->select('products.id', 'products.name', 'products.description', 'products.price')
                ->join('category_product', 'category_product.product_id', '=', 'products.id')
                ->where('category_product.category_id', '=', "{$command->getId()}")
                ->get();
            $result = [];
            foreach ($products as $v) {
                $result[] = [
                    'id_product' => $v->id,
                    'name' => $v->name,
                    'description' => $v->description,
                    'price' => $v->price,
                    'category' => [
                        'id_category' => $category->id,
                        'category_name' => $category->name,
                    ]
                ];
            }
            return $result;
        }
    }

    /**
     * @param UpdateCommand $command
     * @return Category
     */
    public function updateCategory(UpdateCommand $command): Category
    {
        /**
         * @var $category Category
         */
        $category = $this->query()->find($command->getId());
        if (is_null($category)) {
            throw new \DomainException("Категории с id = {$command->getId()} не существует");
        } else {
            $category->name = $command->getName();
            $category->parent_id = $this->checkParentIdForExistingId($command->getParentId());
            $category->external_id = $command->getExternalId();
            $category->update();
            if ($category->update()) {
                return $category;
            } else {
                throw new \DomainException('Возникла ошибка при обновлении категории');
            }
        }
    }

    /**
     * @param DestroyCommand $command
     * @return Category
     * @throws Exception
     */
    public function deleteCategory(DestroyCommand $command): Category
    {
        /**
         * @var $category Category
         */
        $category = $this->query()->find($command->getId());
        if (is_null($category)) {
            throw new \DomainException("Категории с id = {$command->getId()} не существует");
        } else {
            $category->delete();
            DB::table('category_product')->where('category_id','=',"{$command->getId()}")->delete();
            return $category;
        }
    }

}


