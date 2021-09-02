<?php

namespace App\Controller;

use App\Cryptocurrency\DTO\FindCryptoCurrencyPairsDTO;
use App\Service\Cryptocurrency\CryptocurrencyServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class IndexController extends AbstractController
{
    /**
     * @Route("/cryptocurrency/price", methods={"GET"}, name="cryptocurrency_price")
     */
    public function price(
        Request $request,
        ValidatorInterface $validator,
        CryptocurrencyServiceInterface $cryptocurrencyService
    ): Response {
        try {
            //todo: limit, offset
            $source = $request->get('source');
            $targets = $request->get('targets');
            $dateFrom = $request->get('date_from');
            $dateTo = $request->get('date_to');

            //todo: more check
            $constraint = new Assert\Collection([
                'source' => new Assert\NotBlank(),
                'targets' => new Assert\NotBlank(),
                'date_from' => [new Assert\NotBlank(), new Assert\DateTime('Y-m-d'),],
                'date_to' => [new Assert\NotBlank(), new Assert\DateTime('Y-m-d'),],
            ]);

            $errors = $validator->validate([
                'source' => $source,
                'targets' => $targets,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ], $constraint);

            if ($errors->count() > 0) {
                //todo: log and transform error messages
                return $this->json(
                    array_map(static function (ConstraintViolationInterface $v) {
                        return [$v->getPropertyPath() => $v->getMessage()];
                    }, (array)$errors->getIterator()),
                    Response::HTTP_BAD_REQUEST
                );
            }

            $targets = explode(',', $targets);
            $pairs = new FindCryptoCurrencyPairsDTO($source, $targets, $dateFrom, $dateTo);

            return $this->json([
                'source' => $source,
                'targets' => $targets,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'limit' => $pairs->getLimit(),
                'offset' => $pairs->getOffset(),
                'pairs' => $cryptocurrencyService->getPairs($pairs),
            ]);
        } catch (\Throwable $t) {
            //todo: catch on kernel
            return $this->json('Can\'t find pairs', Response::HTTP_BAD_REQUEST);
        }
    }
}
