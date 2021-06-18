<?php


namespace App\Services\API\JsonAPI;

/**
 * Resource implementation is based on JSON:API Specification (v1.0)
 * for more info see https://jsonapi.org/format/
 *
 * @author Garnik Gasparyan <gasp.garnik+resource.author@gmail.com>
 */
class Resource
{
    // TOP LEVEL
    const DATA = 'data';
    const META = "meta";

    // DATA LEVEL
    const ATTRIBUTES = 'attributes';

    /**
     * Representation to assemble resource in.
     * @var array
     */
    private array $representation = [];

    /**
     * @var array
     */
    private array $attributes = [];

    /**
     * @var array
     */
    private array $relationships = [];

    /**
     * @var array
     */
    private array $meta = [];

    public function arrayRepresentation(): void
    {
        $this->dataLevel();
    }

    private function dataLevel(): void
    {
        $this->representation[self::ATTRIBUTES] = $this->attributes;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getRepresentation(): array
    {
        return $this->representation;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     */
    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }
}
