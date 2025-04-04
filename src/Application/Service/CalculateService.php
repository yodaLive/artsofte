<?php

namespace App\Application\Service;

use App\Domain\CreditContext\Entity\CreditProgram;

class CalculateService {
    public function calculate(int $price, int $initialPayment, CreditProgram $program): float
    {
        $loanAmount = $price - $initialPayment;
        $monthlyRate = $program->getInterestRate() / 12 / 100;
        $payment = $loanAmount * $monthlyRate * pow(1 + $monthlyRate, $program->getMaxLoanTermMonths())
            / (pow(1 + $monthlyRate, $program->getMaxLoanTermMonths()) - 1);
        return round($payment, 2);
    }
}