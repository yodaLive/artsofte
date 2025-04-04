<?php

namespace App\Tests\application\Presentation\Controller\V1\Car;

use App\Tests\application\Presentation\Controller\AppTestCase;

class GetCarTest extends AppTestCase
{
    public function testGetCarSuccess(): void
    {
        $this->get('/api/v1/car/1');

        $this->assertResponseStatusCodeSame(200);

        $response = $this->getResponseJSON();

        $this->assertObjectHasProperty('id', $response);
    }

    public function testGetCarNotFoundError(): void
    {
        $this->get('/api/v1/car/100');

        $this->assertResponseStatusCodeSame(404);
    }
}