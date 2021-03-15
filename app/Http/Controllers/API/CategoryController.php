<?php

namespace App\Http\Controllers\API;


use App\Models\Category\Dto\InsertCategory;
use App\Models\Category\Dto\UpdateCategory;
use App\Models\Category\Entity\Category;
use App\Models\Category\UseCase\Destroy\Command as DestroyCommand;
use App\Models\Category\UseCase\Destroy\Handler as DestroyHandler;
use App\Models\Category\UseCase\Index\Handler;
use App\Models\Category\UseCase\Show\Command as ShowCommand;
use App\Models\Category\UseCase\Show\Handler as ShowHandler;
use App\Models\Category\UseCase\Store\Command;
use App\Models\Category\UseCase\Store\Handler as InsertHandler;
use App\Models\Category\UseCase\Update\Command as UpdateCommand;
use App\Models\Category\UseCase\Update\Handler as UpdateHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class CategoryController extends RespController
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $handle = new Handler();
            return $this->getResponse($handle->handle(), 'Список категорий получен');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $dto = new InsertCategory(
                (string)$request->post('name'),
                (int)$request->post('parent_id'),
                Uuid::uuid4()->toString()
            );

            $command = new Command($dto);
            $handle = new InsertHandler();
            return $this->getResponse($handle->handle($command), 'Категория успешно добавлена');

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
            return $this->getResponse($handle->handle($command), "Cписок товаров id категории = {$id} получен");
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
            $dto = new UpdateCategory(
                (int)$id,
                (string)$request->query('name'),
                (int)$request->query('parent_id'),
                Uuid::uuid4()->toString(),
            );
            $command = new UpdateCommand($dto);
            $handle = new UpdateHandler();
            return $this->getResponse($handle->handle($command), 'Категория успешно обновлена');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $command = new DestroyCommand((int)$id);
            $handle = new DestroyHandler();
            return $this->getResponse($handle->handle($command),'Категория успешно удалена');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }
}
