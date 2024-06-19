<?php

declare(strict_types=1);

namespace spec\PragmaGoTech\Interview\Factory;

use PhpSpec\ObjectBehavior;
use PragmaGoTech\Interview\Enum\FeeEnum;
use PragmaGoTech\Interview\Factory\LoanStrategyFactory;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\CalculatorInterface;
use PragmaGoTech\Interview\Strategy\LoanStrategy;

class LoanStrategyFactorySpec extends ObjectBehavior
{
    private const SHORT_LOAN_FEE_TABLE = [
        1000 => 50,
        2000 => 90,
        3000 => 90,
        4000 => 115,
        5000 => 100,
        6000 => 120,
        7000 => 140,
        8000 => 160,
        9000 => 180,
        10000 => 200,
        11000 => 220,
        12000 => 240,
        13000 => 260,
        14000 => 280,
        15000 => 300,
        16000 => 320,
        17000 => 340,
        18000 => 360,
        19000 => 380,
        20000 => 400,
    ];

    public function let(
        CalculatorInterface $calculator
    ): void {
        $this->beConstructedWith($calculator, self::SHORT_LOAN_FEE_TABLE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(LoanStrategyFactory::class);
    }

    public function it_creates_a_loan_strategy(): void
    {
        $loanStrategy = $this->create(FeeEnum::SHORT_TERM);
        $loanStrategy->shouldBeAnInstanceOf(LoanStrategy::class);
        $loanStrategy->feeTable->shouldBe(self::SHORT_LOAN_FEE_TABLE);
    }
}
