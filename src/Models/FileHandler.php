<?php


namespace App\Models;


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
        if(!$this->isValidFile())
            // TODO: Handle errors properly
            return ["error" => "file is not valid"];

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

        if (!$this->tempFilename()) return []; // TODO: handle file doesn't exits error.

        if ($this->handle === false)
            return []; // TODO: handle file doesn't exits error.

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

}