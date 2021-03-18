<?php


namespace App\Models\Store\UseCase\Update;


use Illuminate\Support\Facades\DB;
use Webmozart\Assert\Assert;

class Command
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Command constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(
        int $id,
        string $name
    )
    {
        $this->validate($id,$name);
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param int $id
     * @param string $name
     */
    public function validate(
        int $id,
        string $name
    )
    {
        Assert::stringNotEmpty($name, 'Поле name должно быть строкой');

        $collection = DB::table('stores')->select('name')->where('name', '=', "$name")->first();
        if (!is_null($collection)) {
            throw new \DomainException('Склад с таким именем уже существует');
        }
        if (is_numeric($name)) {
            throw new \DomainException('Название склада должно быть строкой');
        }
        if ($id === 0) {
            throw new \DomainException('Некорректный id');
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
