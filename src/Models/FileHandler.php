<?php


namespace App\Models;


use App\Services\API\JsonAPI\Error;
use Symfony\Component\HttpFoundation\Response;

class FileHandler
{
    // Keys
    const FILENAME = 'file';
    const NAME = 'name';
    const TEMP_NAME = 'tmp_name';

    // Symbolic Constants
    const LINE_LENGTH = 1000;
    const FIRST_ROW = 0;
    const SEPARATOR = ",";

    // Errors
    const INVALID_FILE = "File is not valid.";
    const NO_FILE = "No file provided.";

    private bool $isValid = true;

    static array $validExtensions = [
        "csv",
        "xls",
        "xlsx"
    ];

    /**
     * @var array $files
    */
    private array $files;

    /**
     * @var false|resource
     */
    private $handle;

    public function __construct()
    {
        $this->files = $_FILES;
        $this->handle = fopen($this->tempFilename(), "r");
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    public function getStructuredFile(): array
    {
        if(!$this->isValidFile()) {
            $this->isValid = false;
            return $this->error(self::INVALID_FILE, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->structuredFile();
    }

    private function isValidFile(): bool
    {
        if(!isset($this->files[self::FILENAME][self::NAME]))
            return false;

        $filename = $this->files[self::FILENAME][self::NAME];
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileType), self::$validExtensions))
            return false;

        return true;
    }

    private function structuredFile(): array
    {
        $rowsToReturn = [];

        if (!$this->tempFilename() || $this->handle === false) {
            $this->isValid = false;
            return $this->error(self::NO_FILE, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $row = self::FIRST_ROW;
        $fields = $this->createFieldsArray();
        while (($data = $this->getDataOfTheRow()) !== null) {
            for ($i = 0; $i < count($data); $i++)
                $rowsToReturn[$row][$fields[$i]] = $data[$i];

            $row++;
        }

        return $rowsToReturn;
    }

    private function createFieldsArray(): array
    {
        if (($data = $this->getDataOfTheRow()) === null)
            return []; // TODO: handle empty array case.

        for ($i = 0; $i < count($data); $i++)
            $data[$i] = strtolower($data[$i]);

        return $data;
    }

    private function getDataOfTheRow(): ?array
    {
        if (($data = fgetcsv($this->handle, self::LINE_LENGTH, self::SEPARATOR)) !== false)
            return $data;

        return null;
    }

    private function tempFilename(): ?string
    {
        return $this->files[self::FILENAME][self::TEMP_NAME] ?? null;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     */
    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }

    private function error(string $message, int $code): array
    {
        $error = new Error();
        $error->setTitle(Response::$statusTexts[$code]);
        $error->setStatus($code);
        $error->setErrors([Error::MESSAGE => $message]);

        $error->arrayRepresentation();
        return $error->getRepresentation();
    }
}