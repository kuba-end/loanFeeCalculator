<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Strategy;

use PragmaGoTech\Interview\Enum\FeeEnum;
use PragmaGoTech\Interview\FeeCalculatorInterface;
use PragmaGoTech\Interview\Model\LoanProposal;

readonly class LoanStrategy
{
    public const FEE_TAG = 'loan.fee_resolver';

    private iterable $calculators;

    public function __construct(iterable $calculators)
    {
        $this->calculators = $calculators;
    }

    public function calculate(LoanProposal $application): float
    {
        $term = FeeEnum::from($application->term());
        $fee = 0.0;
        /** @var FeeCalculatorInterface $calculator */
        foreach ($this->calculators as $calculator) {
            if ($calculator->supports($application, $term->getFeeTable())) {
                $fee = $calculator->calculate($application, $term->getFeeTable());
            }
        }

        return $fee;
   }
}
