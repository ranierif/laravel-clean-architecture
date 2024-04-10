<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Application\Exceptions\BusinessException;
use App\Domain\Entities\EntityInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class RepositoryEloquentAbstract
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var EntityInterface
     */
    protected $entity;

    /**
     * @throws BusinessException
     */
    public function create(EntityInterface $entity): EntityInterface|\Exception|\Throwable
    {
        try {
            $model = $this->model::create($entity->toArray());

            $entity->setId($model->id);
            $entity->setCreatedAt(Carbon::now());
            $entity->setUpdatedAt(Carbon::now());

            return $entity;
        } catch (\Throwable $throwable) {
            throw new BusinessException($throwable->getMessage());
        }
    }

    /**
     * @throws BusinessException
     */
    public function findOneBy(string $key, mixed $value): EntityInterface|null|\Exception|\Throwable
    {
        try {
            $result = $this->model::where([$key => $value])->first();

            if (empty($result)) {
                return null;
            }

            return $this->entity::fromArray($result->toArray());
        } catch (\Throwable $throwable) {
            throw new BusinessException($throwable->getMessage());
        }
    }

    /**
     * @throws BusinessException
     */
    public function findBy(string $key, mixed $value): Collection|\Exception|\Throwable
    {
        try {
            $results = $this->model::where([$key => $value])->get()->toArray();

            $collection = new Collection();

            foreach ($results as $result) {
                $collection->push($this->entity::fromArray($result));
            }

            return $collection;
        } catch (\Throwable $throwable) {
            throw new BusinessException($throwable->getMessage());
        }
    }

    /**
     * @throws BusinessException
     */
    public function findOneWhere(array $filters): EntityInterface|null|\Exception|\Throwable
    {
        try {
            $result = $this->model::where($filters)->first()?->toArray();

            if (is_null($result)) {
                return null;
            }

            return $this->entity::fromArray($result);
        } catch (\Throwable $throwable) {
            throw new BusinessException($throwable->getMessage());
        }
    }

    /**
     * @throws BusinessException
     */
    public function updateOne(EntityInterface $entity, ?array $fields = null): bool|\Exception|\Throwable
    {
        try {
            return (bool) $this->model::where('id', $entity->getId())
                ->update($fields);
        } catch (\Throwable $throwable) {
            throw new BusinessException($throwable->getMessage());
        }
    }
}
