<?php

namespace PragmaGoTech\Interview\Service;

interface CalculatorInterface
{
    public function truncateToDecimal(string $answer): string;
    public function interpolateFee(float $amount, array $feeTable): float;
    public function roundUpLoanAndFeeSum(float $fee, float $amount): float;
}