<?php

namespace App\Application\Repository;

interface CreditRepositoryInterface {
    public function findAffordableCredit(int $initialPayment, int $loanTerm, int $maxMonthlyPayment): array;
}


