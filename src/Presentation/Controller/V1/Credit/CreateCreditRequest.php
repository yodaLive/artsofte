<?php

namespace App\Presentation\Controller\V1\Credit;

use App\Application\Model\Request\CreditRequest\CreateCreditRequestModel;
use App\Application\Repository\CreditRepositoryInterface;
use App\Domain\CreditContext\Entity\CreditRequest;
use App\Infrastructure\Repository\CarRepository;
use App\Presentation\Service\ControllerService;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/v1/request", name: "create_credit_request", methods: ["POST"])]
#[OA\Post(
    description: "Create request",
    summary: "Create request",
    tags: ["Credit"],
    responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: "Success",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                ],
            ),
        ),
    ],
)]
final class CreateCreditRequest extends AbstractController
{
    public function __construct(
        readonly private CarRepository $carRepository,
        readonly private CreditRepositoryInterface $creditRepository,
        readonly private EntityManagerInterface $entityManager,
        readonly private ControllerService $controllerService,
    ) {}

    public function __invoke(
        #[MapRequestPayload(validationFailedStatusCode: Response::HTTP_BAD_REQUEST)] CreateCreditRequestModel $request,
    ): JsonResponse {
        $car = $this->carRepository->find($request->carId);
        if (!$car) {
            throw $this->createNotFoundException("Car not found");
        }

        $program = $this->creditRepository->find($request->programId);
        if (!$program) {
            throw $this->createNotFoundException("Program not found");
        }

        $creditRequest = new CreditRequest(
            initialPayment: $request->initialPayment,
            loanTerm: $request->loanTerm,
            car: $car,
            creditProgram: $program,
        );
        $this->entityManager->persist($creditRequest);
        $this->entityManager->flush();

        return $this->json(
            ["success" => true],
            Response::HTTP_CREATED,
            $this->controllerService->getLocation('credit/request', $creditRequest->getId()),
        );
    }
}