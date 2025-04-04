<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Domain\CarContext\Aggregate\Car;
use App\Domain\CreditContext\Entity\CreditProgram;
use App\Domain\CreditContext\Entity\CreditRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CreditRequestFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $program = $this->getReference(CreditProgramFixtures::PROGRAM_REFERENCE . "1", CreditProgram::class);
        $car = $this->getReference(CarFixtures::CAR_REFERENCE . "1", Car::class);
        $request1 = new CreditRequest(
            initialPayment: $program->getMinInitialPayment(),
            loanTerm: $program->getMaxLoanTermMonths(),
            car: $car,
            creditProgram: $program,
        );
        $manager->persist($request1);

        $program = $this->getReference(CreditProgramFixtures::PROGRAM_REFERENCE . "2", CreditProgram::class);
        $car = $this->getReference(CarFixtures::CAR_REFERENCE . "2", Car::class);
        $request2 = new CreditRequest(
            initialPayment: $program->getMinInitialPayment(),
            loanTerm: $program->getMaxLoanTermMonths(),
            car: $car,
            creditProgram: $program,
        );

        $manager->persist($request2);
        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [
            CarFixtures::class,
            CreditProgramFixtures::class,
        ];
    }
}