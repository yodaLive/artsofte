<?php

namespace App\Presentation\Controller\V1\Credit;

use App\Application\Model\Request\CreditRequest\CalculationCreditModel;
use App\Application\Model\Response\Calculate\CalculateModel;
use App\Application\Repository\CreditRepositoryInterface;
use App\Application\Service\CalculateService;
use App\Domain\CreditContext\Entity\CreditProgram;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/v1/credit/calculate", name: "get_calculate", methods: ["GET"])]
#[OA\Get(
    description: "Calculate credit",
    summary: "Calculate credit",
    tags: ["Credit"],
    parameters: [
        new OA\Parameter(name: 'price', description: 'integer', in: 'path'),
        new OA\Parameter(name: 'initialPayment', description: 'integer', in: 'path'),
        new OA\Parameter(name: 'loanTerm', description: 'integer', in: 'path'),
        new OA\Parameter(name: 'maxMonthlyPayment', description: 'integer', in: 'path'),
    ],
    responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: "Success",
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(ref: new Model(type: CreditProgram::class)),
            ),
        ),
    ],
)]
final class GetCreditCalculate extends AbstractController
{
    public function __construct(
        readonly protected CreditRepositoryInterface $repository,
        readonly protected CalculateService $calculateService,
    ) {}

    public function __invoke(
        #[MapQueryString(validationFailedStatusCode: 400)] CalculationCreditModel $request,
    ): JsonResponse {
        /** @var array<int,CreditProgram> $programs */
        $programs = $this->repository->findAffordableCredit(
            $request->initialPayment,
            $request->loanTerm,
            $request->maxMonthlyPayment,
        );

        if (empty($programs)) {
            throw $this->createNotFoundException("Program not found");
        }
        $items = [];
        foreach ($programs as $program) {
            $payment = $this->calculateService->calculate($request->price, $request->initialPayment, $program);
            $items[] = CalculateModel::create($program, $payment);
        }
        return $this->json($items, Response::HTTP_OK);
    }
}