<?php

namespace App\Console\Commands;


use App\Models\Category\UseCase\Store\Command as InsertCommandCategories;
use App\Models\Product\Entity\Product;
use App\Models\Product\UseCase\Store\Command as InsertCommandProducts;
use Illuminate\Console\Command;

class CategoryProductInsertOrUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CategoryProductInsertOrUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    public function handleProd(): array
    {
        $storage_file = 'products.json';
        $storage = file_get_contents($storage_file);
        $lines = explode(",\n\t", $storage);

        foreach ($lines as $line)
        {
            $product = json_decode($line,true);
        }
        return $product;
    }

    public function handleCat(): array
    {
        $storage_file = 'categories.json';
        $storage = file_get_contents($storage_file);
        $lines = explode(",\n\t", $storage);

        foreach ($lines as $line)
        {
            $category = json_decode($line,true);
        }
        return $category;
    }
}
