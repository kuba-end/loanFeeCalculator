<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Factory;

use PragmaGoTech\Interview\Enum\FeeEnum;
use PragmaGoTech\Interview\Service\CalculatorInterface;
use PragmaGoTech\Interview\Strategy\LoanStrategy;

readonly class LoanStrategyFactory implements LoanStrategyFactoryInterface
{
    public function __construct(
        private CalculatorInterface $calculator
    ) {
    }

    public function create(FeeEnum $term): LoanStrategy
    {
        return new LoanStrategy($this->calculator, $term->getFeeTable());
    }
}
