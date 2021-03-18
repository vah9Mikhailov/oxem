<?php


namespace App\Models\Product\UseCase\InsertOrUpdate;


use App\Models\Product\Dto\Insert;
use DomainException;
use Webmozart\Assert\Assert;

class Command
{
    /**
     * @var string
     */
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->validate();
    }


    private function validate()
    {
        if (!file_exists($this->fileName)) {
            throw new \DomainException('ФАЙЛА НЕ СУЩЕСТВУЕТ');
        }
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

}
