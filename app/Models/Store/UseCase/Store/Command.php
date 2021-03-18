<?php


namespace App\Models\Store\UseCase\Store;


use Illuminate\Support\Facades\DB;
use Webmozart\Assert\Assert;

class Command
{

    /**
     * @var string
     */
    private $name;

    /**
     * Command constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    /**
     * @param string $name
     */
    public function validate(string $name)
    {
        Assert::stringNotEmpty($name, 'Поле name должно быть строкой');

        $collection = DB::table('stores')->select('name')->where('name', '=', "$name")->first();
        if (!is_null($collection)) {
            throw new \DomainException('Склад с таким именем уже существует');
        }
        if (is_numeric($name)) {
            throw new \DomainException('Название склада должно быть строкой');
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
