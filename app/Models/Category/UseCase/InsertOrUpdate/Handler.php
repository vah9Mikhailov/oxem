<?php


namespace App\Models\Category\UseCase\InsertOrUpdate;


use App\Models\Category\Dto\Insert;
use App\Models\Category\Entity\Category;
use App\Models\Category\Services\CategoryService;
use App\Models\Category\UseCase\Store\Command as InsertCommand;

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

            foreach ($lines as $line)
            {
                $category = json_decode($line,true);
            }

            foreach ($category as $categories) {
                $dto = new Insert(
                    (string)$categories['name'],
                    (int)$categories['parent_id'],
                    (string)$categories['external_id']
                );
                $comm = new InsertCommand($dto);
                $handle = new CategoryService(new Category());
                $handle = $handle->handle($comm);
                $result[] = $handle;
            }
            var_dump($result,'Категории успешно сохранены');
            die();
        } catch (\DomainException $e) {
            var_dump($e->getMessage());
        }
    }
}
