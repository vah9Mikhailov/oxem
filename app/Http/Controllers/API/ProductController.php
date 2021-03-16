<?php

namespace App\Http\Controllers\API;


use App\Models\Product\Dto\Insert;
use App\Models\Product\Dto\Update;
use App\Models\Product\UseCase\Destroy\Command as DestroyCommand;
use App\Models\Product\UseCase\Destroy\Handler as DestroyHandler;
use App\Models\Product\UseCase\Index\Command;
use App\Models\Product\UseCase\Index\Handler;
use App\Models\Product\UseCase\Show\Command as ShowCommand;
use App\Models\Product\UseCase\Show\Handler as ShowHandler;
use App\Models\Product\UseCase\Store\Command as InsertCommand;
use App\Models\Product\UseCase\Store\Handler as InsertHandler;
use App\Models\Product\UseCase\Update\Command as UpdateCommand;
use App\Models\Product\UseCase\Update\Handler as UpdateHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

            $dto = new Insert(
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
        } catch (\DomainException $e) {
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
        try {
            $requestCategs = $request->query('categories');
            $requestSts = $request->query('stores');
            $requestQuanty = $request->query('quantity');
            $categs = [];
            $sts = [];
            $qty = [];

            if (is_array($requestCategs)) {
                $categs = $requestCategs;
            } elseif (is_string($requestCategs)) {
                $categs[] = $requestCategs;
            }

            if (is_array($requestSts)) {
                $sts = $requestSts;
            } elseif (is_string($requestSts)) {
                $sts[] = $requestSts;
            }

            if (is_array($requestQuanty)) {
                $qty = $requestQuanty;
            } elseif (is_string($requestQuanty)) {
                $qty[] = $requestQuanty;
            }


            $dto = new Update(
                (int)$id,
                $request->query('name') ? (string)$request->query('name') : null,
                $request->query('description') ? (string)$request->query('description') : null,
                $request->query('price') ? (float)$request->query('price') : null,
                Uuid::uuid4()->toString(),
                $categs ? $categs : null,
                $sts ? $sts : null,
                $qty ? $qty : null,
            );

            $command = new UpdateCommand($dto);
            $handle = new UpdateHandler();
            return $this->getResponse($handle->handle($command), 'Товар успешно обновлён');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        try {
            $command = new DestroyCommand((int)$id);
            $handle = new DestroyHandler();
            return $this->getResponse($handle->handle($command), 'Товар успешно удалён');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }
}
