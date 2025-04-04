<?php

namespace App\Presentation\Controller\V1\Car;

use App\Application\Model\Response\Car\CarModel;
use App\Domain\CarContext\Aggregate\Car;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route("/api/v1/car/{id}", name: "get_car", methods: ["GET"])]
#[OA\Get(
    description: "Get car",
    summary: "Get car by id",
    tags: ["Car"],
    parameters: [new OA\Parameter(name: 'id', description: 'integer', in: 'path')],
    responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: "Success",
            content: new OA\JsonContent(ref: new Model(type: CarModel::class)),
        ),
    ],
)]

final class GetCar extends AbstractController
{
    public function __construct() {}

    public function __invoke(
        #[MapEntity(id: 'id', message: 'Машина не найдена.')] Car $car,
    ): JsonResponse {
        return $this->json(CarModel::create($car), Response::HTTP_OK);
    }
}