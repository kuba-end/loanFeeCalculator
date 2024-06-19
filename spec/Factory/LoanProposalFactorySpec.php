<?php

declare(strict_types=1);

namespace spec\PragmaGoTech\Interview\Factory;

use PhpSpec\ObjectBehavior;
use PragmaGoTech\Interview\Factory\LoanProposalFactory;
use PragmaGoTech\Interview\Model\LoanProposal;

class LoanProposalFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(LoanProposalFactory::class);
    }

    public function it_creates_a_loan_proposal()
    {
        $term = 24;
        $amount = 5000.0;

        $loanProposal = $this::create($term, $amount);
        $loanProposal->shouldBeAnInstanceOf(LoanProposal::class);
        $loanProposal->term()->shouldReturn($term);
        $loanProposal->amount()->shouldReturn($amount);
    }
}
