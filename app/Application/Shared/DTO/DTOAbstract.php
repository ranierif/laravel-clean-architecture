<?php

declare(strict_types=1);

namespace App\Application\Shared\DTO;

use App\Domain\Shared\Helper\StrHelper;
use InvalidArgumentException;

abstract class DTOAbstract
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $datum) {
            $this->set($key, $datum);
        }
    }

    public function toArray(): array
    {
        $ar = [];
        foreach ($this->getProperties() as $key) {
            if (isset($this->$key)) {
                $ar[StrHelper::snakeCase($key)] = $this->get($key);
            }
        }

        return $ar;
    }

    public function toJson($options = 0): false|string
    {
        return json_encode($this->toArray(), $options);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        $property = StrHelper::camelCase($name);
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        throw new InvalidArgumentException(
            'Property '.$property.' does not exist on '.get_class($this)
        );
    }

    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    public function set($name, $value)
    {
        $property = StrHelper::camelCase($name);
        if (! property_exists($this, $property)) {
            throw new InvalidArgumentException(
                'Can\'t set property '.$property.' that does not exist on '.get_class($this)
            );
        }
        $this->{$property} = $value;
    }

    private function getProperties(): array
    {
        return array_keys(get_object_vars($this));
    }
}
