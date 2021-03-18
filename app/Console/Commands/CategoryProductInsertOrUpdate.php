<?php

namespace App\Console\Commands;


use App\Models\Category\UseCase\InsertOrUpdate\Command as CatCommand;
use App\Models\Category\UseCase\InsertOrUpdate\Handler;
use App\Models\Product\UseCase\InsertOrUpdate\Command as ProdCommand;
use App\Models\Product\UseCase\InsertOrUpdate\Handler as ProdHandler;
use Illuminate\Console\Command;

class CategoryProductInsertOrUpdate extends Command
{

    const TYPE_CATEGORY = 'category';
    const TYPE_PRODUCT = 'product';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CategoryProductInsertOrUpdate {--command=}';

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
    public function handle(): array
    {
        $command = $this->option('command');

        switch ($command){
            case self::TYPE_CATEGORY:
                $storage_file = public_path() . '/' . 'categories.json';
                $command = new CatCommand($storage_file);
                $handle = new Handler();
                break;
            case self::TYPE_PRODUCT:
                $storage_file = public_path() . '/' . 'products.json';
                $command = new ProdCommand($storage_file);
                $handle = new ProdHandler();
                break;
            default:
                echo 'Invalid command type' . PHP_EOL;
                die();
        }
        $handle->handle($command);
        die();
    }

}
