<?php


namespace App\Models\Store\UseCase\Store;


use App\Models\Store\Entity\Store;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        $store = new Store();
        $store = $store->createStore($command);
        return $store->toArray();
    }
}
