<?php

declare(strict_types=1);

namespace App\Domain\CreditContext\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'credit_programs')]
class CreditProgram
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', nullable: false)]
    private string $name;

    #[ORM\Column(name: 'min_initial_payment', type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private int $minInitialPayment;

    #[ORM\Column(name: 'max_monthly_payment', type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private int $maxMonthlyPayment;

    #[ORM\Column(name: 'max_loan_term_months', type: 'integer', nullable: false)]
    private int $maxLoanTermMonths;

    #[ORM\Column(name: 'interest_rate', type: 'decimal', precision: 10, scale: 1, nullable: false)]
    private float $interestRate;

    public function __construct(
        string $name,
        int $minInitialPayment,
        int $maxMonthlyPayment,
        int $maxLoanTermMonths,
        float $interestRate,
        ?int $id = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->minInitialPayment = $minInitialPayment;
        $this->maxMonthlyPayment = $maxMonthlyPayment;
        $this->maxLoanTermMonths = $maxLoanTermMonths;
        $this->interestRate = $interestRate;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getMaxMonthlyPayment(): int
    {
        return $this->maxMonthlyPayment;
    }

    public function getMaxLoanTermMonths(): int
    {
        return $this->maxLoanTermMonths;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getMinInitialPayment(): int
    {
        return $this->minInitialPayment;
    }

    public function getId(): int
    {
        return $this->id;
    }
}