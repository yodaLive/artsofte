<?php

namespace App\Application\Model\Request\CreditRequest;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCreditRequestModel
{

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $carId,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $programId,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $initialPayment,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        public int $loanTerm,
    ) {}
}