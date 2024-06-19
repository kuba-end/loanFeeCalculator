<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Strategy;

use PragmaGoTech\Interview\FeeCalculatorInterface;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\CalculatorInterface;

readonly class LoanStrategy implements FeeCalculatorInterface
{
    public function __construct(
        private CalculatorInterface $calculator,
        public array $feeTable
    ) {

    }

    public function calculate(LoanProposal $application): float
    {
        $amount = $application->amount();

        return $this->feeTable[$amount] ?? $this->calculator->interpolateFee($amount, $this->feeTable);
    }
}
