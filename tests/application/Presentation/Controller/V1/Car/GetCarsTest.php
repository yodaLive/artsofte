<?php

namespace App\Tests\application\Presentation\Controller\V1\Car;

use App\Tests\application\Presentation\Controller\AppTestCase;

class GetCarsTest extends AppTestCase
{
    public function testGetCarList(): void
    {
        $this->get('/api/v1/cars');

        $this->assertResponseStatusCodeSame(200);

        $response = $this->getResponseJSON();

        $this->assertIsArray($response);
        $this->assertObjectHasProperty('id', $response[0]);
    }
}