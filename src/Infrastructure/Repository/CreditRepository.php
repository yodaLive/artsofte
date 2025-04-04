<?php

namespace App\Infrastructure\Repository;

use App\Application\Repository\CreditRepositoryInterface;
use App\Domain\CreditContext\Entity\CreditProgram;

class CreditRepository extends AbstractRepository implements CreditRepositoryInterface
{
    private const string ENTITY_CLASS = CreditProgram::class;
    protected static function getEntityClass(): string
    {
        return self::ENTITY_CLASS;
    }

    final public function findAffordableCredit(int $initialPayment, int $loanTerm, int $maxMonthlyPayment): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('c')
            ->from(CreditProgram::class, 'c')
            ->where('c.minInitialPayment < :initialPayment')
            ->andWhere('c.maxLoanTermMonths > :loanTerm')
            ->andWhere('c.maxMonthlyPayment > :maxLoanTermMonths')
            ->setParameter('initialPayment', $initialPayment)
            ->setParameter('loanTerm', $loanTerm)
            ->setParameter('maxLoanTermMonths', $maxMonthlyPayment);
        return $qb->getQuery()->getResult();
    }

}