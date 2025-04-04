<?php

namespace App\Tests\application\Presentation\Controller\V1\Credit;

use App\Tests\application\Presentation\Controller\AppTestCase;

class GetCreditCalculateTest extends AppTestCase
{
    public function testGetCalculateSuccess(): void
    {
        $this->get(
            '/api/v1/credit/calculate?price=200000001&initialPayment=8000001&loanTerm=35&maxMonthlyPayment=14000',
        );

        $this->assertResponseStatusCodeSame(200);

        $response = $this->getResponseJSON();

        $this->assertIsArray($response);
        $this->assertObjectHasProperty('programId', $response[0]);
    }

    public function testGetCalculateError(): void
    {
        $this->get(
            '/api/v1/credit/calculate?price=200000001&initialPayment=we&loanTerm=35&maxMonthlyPayment=14000',
        );

        $this->assertResponseStatusCodeSame(400);
    }
}