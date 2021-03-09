<?php

namespace App\Http\Controllers\API;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class CategoryController extends RespController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $category = Category::all();
        return $this->getResponse($category->toArray(),'Список категорий получен');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['external_id'] = Uuid::uuid4()->toString();
        $data['products'] = $request->products;
        $validator = Validator::make($data, [
            'name' => 'required|max:200',
            'parent_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->getError('Ошибка валидации', $validator->errors());
        }


        $category = Category::query()->create($data);
        if ($category->parent_id = $data['parent_id'] > $category->id){
            return $this->getError('Родительской категории не существует');
        }else if ($category->parent_id = $data['parent_id'] == $category->id){
            return $this->getError('Родительская категория не может быть у самой себя');
        } else {
            $category->products()->sync($request->products);
            return $this->getResponse($category->toArray(), 'Товар готов');
        }
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $categories = Category::query()->where('id', $id)->first();
        $products = $categories->products()->get();
        if(is_null($categories)){
            return $this->getError('Категории не существует');
        }
        if (is_null($products)){
            return $this->getError('Нет товаров в данной категории');
        } else{
            return $this->getResponse($products->toArray(),'Товары данной категории получены');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $category = Category::query()->find($id);
        if (is_null($category)) {
            return $this->getError('Товар не найден');
        } else {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|max:200',
                'parent_id' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return $this->getError('Ошибка валидации', $validator->errors());
            }
            if ($category->parent_id = $data['parent_id'] > $category->id){
                return $this->getError('Родительской категории не существует');
            }else if ($category->parent_id = $data['parent_id'] == $category->id){
                return $this->getError('Родительская категория не может быть у самой себя');
            } else {
                $category->name = $data['name'];
                $category->parent_id = $data['parent_id'];
                $category->save();
                return $this->getResponse($category->toArray(), 'Товар обновлён');
            }

        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $category = Category::query()->find($id);
        if (is_null($category)){
            return $this->getError('Товар не найден');
        }else {
            $category->delete();
            $category->categories()->sync([]);
            return $this->getResponse($category->toArray(), 'Категория удалена');
        }
    }
}
