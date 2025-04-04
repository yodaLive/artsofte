<?php

namespace App\Application\Model\Request\CreditRequest;

use Symfony\Component\Validator\Constraints as Assert;

class CalculationCreditModel
{

    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\Type('float')]
        public float $price,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\Type('integer')]
        public int $maxMonthlyPayment,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\Type('integer')]
        public int $loanTerm,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\Type('integer')]
        public int $initialPayment,
    ) {}
}