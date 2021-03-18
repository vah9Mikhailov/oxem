<?php


namespace App\Models\Store\UseCase\Update;


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
        $store = $store->updateStore($command);
        return $store->toArray();
    }
}
