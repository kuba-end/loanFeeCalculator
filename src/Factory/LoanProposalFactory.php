<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Factory;

use PragmaGoTech\Interview\Model\LoanProposal;

class LoanProposalFactory
{
    public static function create(int $term, float $amount): LoanProposal
    {
        return new LoanProposal($term, $amount);
    }
}
