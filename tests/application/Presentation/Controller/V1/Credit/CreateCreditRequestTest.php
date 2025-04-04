<?php

namespace App\Tests\application\Presentation\Controller\V1\Credit;

use App\Tests\application\Presentation\Controller\AppTestCase;

class CreateCreditRequestTest extends AppTestCase
{
    public function testCreateCreditSuccess(): void
    {
        $this->post('/api/v1/request', [
            "carId" => 1,
            "programId" => 1,
            "initialPayment" => 2323232,
            "loanTerm" => 12,
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateCreditErrorInvalidField(): void
    {
        $this->post('/api/v1/request', [
            "carId1" => 1,
            "programId" => 1,
            "initialPayment" => 2323232,
            "loanTerm" => 12,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateCreditErrorNotFoundCar(): void
    {
        $this->post('/api/v1/request', [
            "carId" => 100,
            "programId" => 1,
            "initialPayment" => 2323232,
            "loanTerm" => 12,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCreateCreditErrorNotFoundProgram(): void
    {
        $this->post('/api/v1/request', [
            "carId" => 1,
            "programId" => 100,
            "initialPayment" => 2323232,
            "loanTerm" => 12,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }
}