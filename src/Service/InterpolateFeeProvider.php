<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service;

use PragmaGoTech\Interview\FeeCalculatorInterface;
use PragmaGoTech\Interview\Model\LoanProposal;

class InterpolateFeeProvider implements FeeCalculatorInterface
{
    public function supports(LoanProposal $application, array $feeTable): bool
    {
        return !isset($feeTable[$application->amount()]);
    }

    public function calculate(LoanProposal $application, array $feeTable): float
    {
        $amount = $application->amount();
        $closestLower = $this->calculateClosestLower($amount, $feeTable);
        $closestHigher = $this->calculateClosestHigher($amount, $feeTable);
        $d = ($amount - $closestLower) / ($closestHigher - $closestLower);

        return $feeTable[$closestLower] * (1 - $d) + $feeTable[$closestHigher] * $d;
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
