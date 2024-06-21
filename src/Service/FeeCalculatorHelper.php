<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service;

class FeeCalculatorHelper implements FeeCalculatorHelperInterface
{
    public function roundUpLoanAndFeeSum(float $fee, float $amount): float
    {
        $roundedUpSum = ceil(($fee + $amount) / 5) * 5;

        return $roundedUpSum - $amount;
    }
}
