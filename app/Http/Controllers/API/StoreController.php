<?php

namespace App\Http\Controllers\API;


use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|unique:stores'
        ]);

        if ($validator->fails()){
            return $this->getError('Ошибка валидации',$validator->errors());
        }
        $store = Store::query()->create($data);
        return $this->getResponse($store->toArray(),'Склад успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        //
    }*/

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $store = Store::query()->find($id);
        if (is_null($store))
        {
            return $this->getError('Склад не найден');
        } else{
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|unique:stores'
            ]);
            if ($validator->fails()){
                return $this->getError('Ошибка валидации',$validator->errors());
            }

            $store->name = $data['name'];
            $store->update();
            return $this->getResponse($store->toArray(),'Склад обновлён');
        }





    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $store = Store::query()->find($id);
        if (is_null($store)){
            return $this->getError('Склад не найден');
        }
        $store->delete();
        return  $this->getResponse($store->toArray(),'Склад удалён');

    }
}
