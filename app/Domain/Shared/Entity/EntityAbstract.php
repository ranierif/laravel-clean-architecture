<?php

declare(strict_types=1);

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Helper\StrHelper;
use Carbon\Carbon;

abstract class EntityAbstract implements EntityInterface
{
    private ?int $id;

    private Carbon $created_at;

    private ?Carbon $updated_at = null;

    private ?Carbon $deleted_at = null;

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setCreatedAt(Carbon $dateTime): void
    {
        $this->created_at = $dateTime;
    }

    public function setUpdatedAt(?Carbon $dateTime): void
    {
        $this->updated_at = $dateTime ?? null;
    }

    public function setDeletedAt(?Carbon $dateTime): void
    {
        $this->deleted_at = $dateTime ?? null;
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at ?? null;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at ?? null;
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->deleted_at ?? null;
    }

    public static function fromArray(array $parameters): ?static
    {
        $objectParams = [];
        $classParams = static::getParamsFromConstruct();
        foreach ($classParams as $param) {
            if (array_key_exists(StrHelper::snakeCase($param->name), $parameters)) {
                $paramValue = $parameters[StrHelper::snakeCase($param->name)];

                if ($param->getType() && $param->getType()->getName() === Carbon::class && ! empty($paramValue)) {
                    $objectParams[] = new Carbon($paramValue);
                } else {
                    $objectParams[] = $paramValue;
                }
            }
        }

        $entity = new static(...$objectParams);

        if (array_key_exists('id', $parameters)) {
            $entity->setId($parameters['id']);
        }

        if (array_key_exists('created_at', $parameters) && ! is_null($parameters['created_at'])) {
            $createdAt = is_string($parameters['created_at'])
                ? Carbon::parse($parameters['created_at'])
                : $parameters['created_at'];

            $entity->setCreatedAt($createdAt);
        }

        if (array_key_exists('updated_at', $parameters) && ! is_null($parameters['updated_at'])) {
            $updatedAt = is_string($parameters['updated_at'])
                ? Carbon::parse($parameters['updated_at'])
                : $parameters['updated_at'];

            $entity->setUpdatedAt($updatedAt);
        }

        if (array_key_exists('deleted_at', $parameters) && ! is_null($parameters['deleted_at'])) {
            $deletedAt = is_string($parameters['deleted_at'])
                ? Carbon::parse($parameters['deleted_at'])
                : $parameters['deleted_at'];

            $entity->setUpdatedAt($deletedAt);
        }

        if (array_key_exists('approved_at', $parameters) && ! is_null($parameters['approved_at'])) {
            $approvedAt = is_string($parameters['approved_at'])
                ? Carbon::parse($parameters['approved_at'])
                : $parameters['approved_at'];

            $entity->setUpdatedAt($approvedAt);
        }

        return $entity;
    }

    public static function getParamsFromConstruct(): array
    {
        return (new \ReflectionMethod(static::class, '__construct'))->getParameters();
    }

    public function toArray(): array
    {
        $array = [];
        if ((new \ReflectionProperty(static::class, 'id'))->isInitialized($this)) {
            $array['id'] = $this->id;
        }

        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }
}
