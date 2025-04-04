<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, static::getEntityClass());
    }

    public function beginTransaction(): void
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
    }

    public function commitTransaction(): void
    {
        try {
            $em = $this->getEntityManager();
            $em->commit();
            $em->clear();
        } catch (UniqueConstraintViolationException $e) {
            throw new \Exception(sprintf('Aggregate has uniques constraint violations '));
        }
    }

    public function rollbackTransaction(): void
    {
        $em = $this->getEntityManager();
        $em->rollback();
        $em->clear();
    }

    /**
     * @deprecated use persist and flush instead
     */
    public function save($aggregate): void
    {
        $em = $this->getEntityManager();
        $em->persist($aggregate);
        $em->flush();
    }

    /**
     * @return class-string<object>
     */
    abstract protected static function getEntityClass(): string;

}
