<?php


namespace App\Models\Store\UseCase\Destroy;


use App\Models\Store\Entity\Store;
use Exception;

class Handler
{

    /**
     * @param Command $command
     * @return array
     * @throws Exception
     */
    public function handle(Command $command): array
    {
        $store = new Store();
        $store = $store->deleteStore($command);
        return $store->toArray();
    }

}
