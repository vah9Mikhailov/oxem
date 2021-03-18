<?php

namespace App\Models\Store\Entity;

use App\Models\Product\Entity\Product;
use App\Models\Store\UseCase\Destroy\Command as DestroyCommand;
use App\Models\Store\UseCase\Store\Command;
use App\Models\Store\UseCase\Update\Command as UpdateCommand;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @param Command $command
     * @return $this
     */
    public function createStore(Command $command): Store
    {
        $this->name = $command->getName();
        if ($this->save()) {
            return $this;
        } else {
            throw new \DomainException('Возникла ошибка при сохранении склада');
        }
    }

    /**
     * @param UpdateCommand $command
     * @return Store
     */
    public function updateStore(UpdateCommand $command): Store
    {
        /**
         * @var $store Store
         */
        $store = $this->query()->find($command->getId());
        if (!is_null($store)) {
            $store->name = $command->getName();
            $store->update();
        } else {
            throw new \DomainException('Товар не найден');
        }
        return $store;
    }

    /**
     * @param DestroyCommand $command
     * @return Store
     * @throws Exception
     */
    public function deleteStore(DestroyCommand $command): Store
    {
        /**
         * @var $store Store
         */
        $store = $this->query()->find($command->getId());
        if (is_null($store)) {
            throw new \DomainException("Склад с таким id = {$command->getId()} не существует");
        } else {
            $store->delete();
            return $store;
        }
    }
}
