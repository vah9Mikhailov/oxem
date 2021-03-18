<?php


namespace App\Models\Category\UseCase\InsertOrUpdate;


use App\Models\Category\Dto\Insert;
use Webmozart\Assert\Assert;

class Command
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * Command constructor.
     * @param string $fileName
     */
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
