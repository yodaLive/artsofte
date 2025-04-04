<?php

namespace App\Presentation\Controller\V1\Car;

use App\Application\Model\Response\Car\Collection\CarsModel;
use App\Application\Repository\CarRepositoryInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route("/api/v1/cars", name: "get_cars", methods: ["GET"])]
#[OA\Get(
    description: "Get cars",
    summary: "Get cars",
    tags: ["Car"],
    responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: "Success",
            content: new OA\JsonContent(ref: new Model(type: CarsModel::class)),
        ),
    ],
)]

final class GetCars extends AbstractController
{
    public function __construct(
        readonly private CarRepositoryInterface $carRepository,
    ) {}

    public function __invoke(): JsonResponse
    {
        $cars = $this->carRepository->findAll();
        return $this->json(CarsModel::create($cars)->items, Response::HTTP_OK);
    }
}