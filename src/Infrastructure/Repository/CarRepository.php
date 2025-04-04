<?php

namespace App\Infrastructure\Repository;

use App\Application\Repository\CarRepositoryInterface;
use App\Domain\CarContext\Aggregate\Car;

class CarRepository extends AbstractRepository implements CarRepositoryInterface
{
    private const string ENTITY_CLASS = Car::class;
    protected static function getEntityClass(): string
    {
        return self::ENTITY_CLASS;
    }

    final public function findAll(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('r')
            ->from(Car::class, 'r');
        return $qb->getQuery()->getResult();
    }

    final public function findById(int $id): ?Car
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('c')
            ->from(Car::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }
}