<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service;

class Calculator implements CalculatorInterface
{
    public function truncateToDecimal(string $answer): string
    {
        $dotPosition = strpos($answer, '.');

        if ($dotPosition === false) {
            return $answer;
        }
        $integerPart = substr($answer, 0, $dotPosition);
        $decimalPart = substr($answer, $dotPosition + 1, 2);

        return $integerPart . '.' . $decimalPart;
    }

    public function interpolateFee(float $amount, array $feeTable): float
    {
        $closestLower = $this->calculateClosestLower($amount, $feeTable);
        $closestHigher = $this->calculateClosestHigher($amount, $feeTable);
        $d = ($amount - $closestLower) / ($closestHigher - $closestLower);

        return $feeTable[$closestLower] * (1 - $d) + $feeTable[$closestHigher] * $d;
    }

    public function roundUpLoanAndFeeSum(float $fee, float $amount): float
    {
        $roundedUpSum = ceil(($fee + $amount) / 5) * 5;

        return $roundedUpSum - $amount;
    }

    public function calculateClosestLower(float $amount, array $feeTable): ?int
    {
        $closest = null;
        foreach ($feeTable as $key => $breakpoint) {
            if ($key <= $amount) {
                if (null === $closest || abs($key-$closest) > abs($key-$amount)) {
                    $closest = $key;
                }
            }
        }

        return $closest;
    }

    public function calculateClosestHigher(float $amount, array $feeTable): int
    {
        $closest = null;
        foreach ($feeTable as $key => $breakpoint) {
            if ($key > $amount) {
                if (null === $closest || abs($key-$closest) > abs($key-$amount)) {
                    $closest = $key;
                }
            }
        }

        return $closest;
    }
}
