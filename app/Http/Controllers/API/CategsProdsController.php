<?php


namespace App\Http\Controllers\API;


use App\Console\Commands\CategoryProductInsertOrUpdate;
use App\Models\Category\Dto\Insert as CategoryInsert;
use App\Models\Category\UseCase\InsertOrUpdate\Command as InsertOrUpdateCommand;
use App\Models\Category\UseCase\InsertOrUpdate\Handler as InsertOrUpdateHandler;
use App\Models\Product\Dto\Insert;
use App\Models\Product\UseCase\InsertOrUpdate\Command;
use App\Models\Product\UseCase\InsertOrUpdate\Handler;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;


class CategsProdsController extends RespController
{
    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function storeProducts()
    {
        try {
            $product = app()->make(CategoryProductInsertOrUpdate::class)->handleProd();

            foreach ($product as $products) {
                $products['store'] = [];
                if (is_array($products['store_id'])) {
                    $products['store'] = $products['store_id'];
                } elseif (is_int($products['store_id'])) {
                    $products['store'][] = $products['store_id'];
                }

                $products['qty'] = [];
                if (is_array($products['quantity'])) {
                    $products['qty'] = $products['quantity'];
                } elseif (is_int($products['quantity'])) {
                    $products['qty'][] = $products['quantity'];
                }
                $dto = new Insert(
                    (string)$products['name'],
                    (string)$products['description'],
                    (float)$products['price'],
                    (string)$products['external_id'],
                    $products['category_id'],
                    $products['store'],
                    $products['qty'],
                );
                $command = new Command($dto);
                $handle = new Handler();
                $handle = $handle->handle($command);
                $result[] = $handle;
            }
            return $this->getResponse($result,'Товары успешно сохранены');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }

    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function storeCategories()
    {
        try {
            $category = app()->make(CategoryProductInsertOrUpdate::class)->handleCat();

            foreach ($category as $categories) {
                $dto = new CategoryInsert(
                    (string)$categories['name'],
                    (int)$categories['parent_id'],
                    (string)$categories['external_id']
                );
                $command = new InsertOrUpdateCommand($dto);
                $handle = new InsertOrUpdateHandler();
                $handle = $handle->handle($command);
                $result[] = $handle;
            }
            return $this->getResponse($result,'Категории успешно сохранены');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }

    }
}
