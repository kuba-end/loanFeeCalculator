<?php

namespace PragmaGoTech\Interview\Service;

interface FeeCalculatorHelperInterface
{
    public function roundUpLoanAndFeeSum(float $fee, float $amount): float;
}