<?php


namespace App\Models\Product\UseCase\InsertOrUpdate;


use App\Models\Category\Entity\Category;
use App\Models\Product\Dto\Insert;
use App\Models\Product\Entity\Product;
use App\Models\Product\Services\ProductService;
use App\Models\Product\UseCase\Store\Command as InsertCommand;
use App\Models\Store\Entity\Store;

class Handler
{
    /**
     * @param Command $command
     * @return array
     */
    public function handle(Command $command): array
    {
        try {
            $storage = file_get_contents($command->getFileName());
            $lines = explode(",\n\t", $storage);
            foreach ($lines as $line) {
                $product = json_decode($line, true);
            }

            foreach ($product as $products) {
                $products['store'] = [];
                if (is_array($products['store_id'])) {
                    $products['store'] = $products['store_id'];
                } elseif (is_int($products['store_id'])) {
                    $products['store'][] = $products['store_id'];
                }

                $products['qty'] = [];
                if (is_array($products['quantity'])) {
                    $products['qty'] = $products['quantity'];
                } elseif (is_int($products['quantity'])) {
                    $products['qty'][] = $products['quantity'];
                }
                $dto = new Insert(
                    (string)$products['name'],
                    (string)$products['description'],
                    (float)$products['price'],
                    (string)$products['external_id'],
                    $products['category_id'],
                    $products['store'],
                    $products['qty'],
                );
                $comm = new InsertCommand($dto);
                $handle = new ProductService(new Product(), new Category(), new Store());
                $handle = $handle->handle($comm);
                $result[] = $handle;

            }
            var_dump($result,'Товары успешно сохранены');
            die();
        } catch (\DomainException $e) {
            $e->getMessage();
        }
    }
}
