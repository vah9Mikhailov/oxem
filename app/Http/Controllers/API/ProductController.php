<?php

namespace App\Http\Controllers\API;

use App\Dto\UpdateProductDto;
use App\Models\Product\Dto\InsertProduct;
use App\Models\Product\Entity\Product;
use App\Models\Product\UseCase\Index\Command;
use App\Models\Product\UseCase\Index\Handler;
use App\Models\Product\UseCase\Show\Command as ShowCommand;
use App\Models\Product\UseCase\Show\Handler as ShowHandler;
use App\Models\Product\UseCase\Store\Command as InsertCommand;
use App\Models\Product\UseCase\Store\Handler as InsertHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ProductController extends RespController
{


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $command = new Command((string)$request->s);
            $handler = new Handler();
            return $this->getResponse($handler->handle($command), "Sort by {$command->getSortType()->getCurrent()}");
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $requestCategories = $request->post('categories');
            $requestStores = $request->post('stores');
            $requestQuantity = $request->post('quantity');
            $categories = [];
            $stores = [];
            $quantity = [];


            if (is_array($requestCategories)) {
                $categories = $requestCategories;
            } elseif (is_string($requestCategories)) {
                $categories[] = $requestCategories;
            }

            if (is_array($requestStores)) {
                $stores = $requestStores;
            } elseif (is_string($requestStores)) {
                $stores[] = $requestStores;
            }
            if (is_array($requestQuantity)) {
                $quantity = $requestQuantity;
            } elseif (is_string($requestQuantity)) {
                $quantity[] = $requestQuantity;
            }

            $dto = new InsertProduct(
                (string)$request->post('name'),
                (string)$request->post('description'),
                (float)$request->post('price'),
                Uuid::uuid4()->toString(),
                $categories,
                $stores,
                $quantity,
            );
            $command = new InsertCommand($dto);
            $handler = new InsertHandler();

            return $this->getResponse($handler->handle($command), 'Товар успешно добавлен');
        } catch (\DomainException $e){
            return $this->getError($e->getMessage());
        }

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $command = new ShowCommand((int)$id);
            $handle = new ShowHandler();
            return $this->getResponse($handle->handle($command), "Товар c id = {$command->getId()} получен");
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /**
         * @var $product Product
         */
        $product = Product::query()->find($id);
        if (is_null($product)) {
            return $this->getError('Товар не найден');
        } else {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|max:200',
                'description' => 'required|max:1000',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
            ]);
            $data['categories'] = $request->categories;

            if ($validator->fails()) {
                return $this->getError('Ошибка валидации', $validator->errors());
            }

            $updateProductDto = new UpdateProductDto(
                (string)$data['name'],
                (string)$data['description'],
                (float)$data['price'],
                (string)$data['category_id']
            );

            $product->updateProductInfo($updateProductDto);

            /*$product->name = $data['name'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->quantity = $data['quantity'];
            $product->categories()->sync($request->categories);
            $product->update();*/
            return $this->getResponse($product->toArray(), 'Товар обновлён');
        }

    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = Product::query()->find($id);
        if (is_null($product)) {
            return $this->getError('Товар не найден');
        } else {
            $product->delete();
            $product->categories()->sync([]);
            return $this->getResponse($product->toArray(), 'Товар удалён');
        }
    }
}
