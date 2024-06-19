<?php

namespace PragmaGoTech\Interview\Factory;

use PragmaGoTech\Interview\Enum\FeeEnum;
use PragmaGoTech\Interview\Strategy\LoanStrategy;

interface LoanStrategyFactoryInterface
{
    public function create(FeeEnum $term): LoanStrategy;
}