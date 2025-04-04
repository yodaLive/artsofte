<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Domain\CreditContext\Entity\CreditProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreditProgramFixtures extends Fixture
{
    public const string PROGRAM_REFERENCE = 'program';

    public function load(ObjectManager $manager): void
    {
        $pathToJson = __DIR__ . '/data/creditPrograms.json';
        $data = json_decode(file_get_contents($pathToJson), true);

        foreach ($data as $item) {
            $creditProgram = new CreditProgram(
                name: $item['name'],
                minInitialPayment: $item['minInitialPayment'],
                maxMonthlyPayment: $item['maxMonthlyPayment'],
                maxLoanTermMonths: $item['maxLoanTermMonths'],
                interestRate: $item['interestRate'],
                id: $item['id'],
            );
            $manager->persist($creditProgram);
            $this->addReference(self::PROGRAM_REFERENCE . $item['id'], $creditProgram);
        }
        $manager->flush();
        $manager->clear();
    }
}