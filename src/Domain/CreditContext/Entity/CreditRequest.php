<?php

declare(strict_types=1);

namespace App\Domain\CreditContext\Entity;

use App\Domain\CarContext\Aggregate\Car;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'credit_requests')]
class CreditRequest
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'initial_payment', type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private float $initialPayment;

    #[ORM\Column(name: 'loan_term', type: 'integer', nullable: false)]
    private int $loanTerm;

    #[ORM\ManyToOne(targetEntity: Car::class, inversedBy: 'requests')]
    #[ORM\JoinColumn(name: 'car_id', referencedColumnName: 'id', nullable: false)]
    private Car $car;

    #[ORM\ManyToOne(targetEntity: CreditProgram::class, inversedBy: 'requests')]
    #[ORM\JoinColumn(name: 'credit_program_id', referencedColumnName: 'id', nullable: false)]
    private CreditProgram $creditProgram;


    public function __construct(
        float $initialPayment,
        int $loanTerm,
        Car $car,
        CreditProgram $creditProgram,
    ) {
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
        $this->car = $car;
        $this->creditProgram = $creditProgram;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function setCreditProgram(CreditProgram $creditProgram): void
    {
        $this->creditProgram = $creditProgram;
    }

    public function getCreditProgram(): CreditProgram
    {
        return $this->creditProgram;
    }

    public function getInitialPayment(): float
    {
        return $this->initialPayment;
    }
}