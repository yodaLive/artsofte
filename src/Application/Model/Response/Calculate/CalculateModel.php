<?php

declare(strict_types=1);

namespace App\Application\Model\Response\Car;

namespace App\Application\Model\Response\Calculate;

use App\Domain\CreditContext\Entity\CreditProgram;

final class CalculateModel
{

    public int $programId {
        get => $this->programId;
    }

    public int $interestRate {
        get => $this->interestRate;
    }

    public float $monthlyPayment {
        get => $this->monthlyPayment;
    }

    public string $title {
        get => $this->title;
    }

    /**
     * @param CreditProgram $creditProgram
     * @param float $monthlyPayment ,
     * @return self
     */
    public static function create(CreditProgram $creditProgram, float $monthlyPayment): self
    {
        $response = new self();
        $response->programId = $creditProgram->getId();
        $response->title = $creditProgram->getName();
        $response->monthlyPayment = $monthlyPayment;

        return $response;
    }
}
