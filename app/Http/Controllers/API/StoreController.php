<?php

namespace App\Http\Controllers\API;


use App\Models\Store;
use App\Models\Store\UseCase\Destroy\Command as DestroyCommand;
use App\Models\Store\UseCase\Destroy\Handler as DestroyHandler;
use App\Models\Store\UseCase\Store\Command;
use App\Models\Store\UseCase\Store\Handler;
use App\Models\Store\UseCase\Update\Command as UpdateCommand;
use App\Models\Store\UseCase\Update\Handler as UpdateHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends RespController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        //
    }*/

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $command = new Command(
                (string)$request->post('name')
            );
            $handle = new Handler();
            return $this->getResponse($handle->handle($command), 'Склад успешно добавлен');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        //
    }*/

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $command = new UpdateCommand(
                (int)$id,
                (string)$request->query('name')
            );
            $handle = new UpdateHandler();
            return $this->getResponse($handle->handle($command), 'Название склада успешно обновлено');
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
            return $this->getResponse($handle->handle($command), 'Склад успешно удалён');
        } catch (\DomainException $e) {
            return $this->getError($e->getMessage());
        }
    }
}
