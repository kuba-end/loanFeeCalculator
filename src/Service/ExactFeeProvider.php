<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service;

use PragmaGoTech\Interview\FeeCalculatorInterface;
use PragmaGoTech\Interview\Model\LoanProposal;

class ExactFeeProvider implements FeeCalculatorInterface
{
    public function supports(LoanProposal $application, array $feeTable): bool
    {
        return isset($feeTable[$application->amount()]);
    }

    public function calculate(LoanProposal $application, array $feeTable): float
    {
        return $feeTable[$application->amount()];
    }
}
