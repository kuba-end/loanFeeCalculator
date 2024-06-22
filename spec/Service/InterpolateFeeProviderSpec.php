<?php

declare(strict_types=1);

namespace spec\PragmaGoTech\Interview\Service;

use PhpSpec\ObjectBehavior;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\InterpolateFeeProvider;

class InterpolateFeeProviderSpec extends ObjectBehavior
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

    private const LONG_LOAN_FEE_TABLE = [
        1000 => 70,
        2000 => 100,
        3000 => 120,
        4000 => 160,
        5000 => 200,
        6000 => 240,
        7000 => 280,
        8000 => 320,
        9000 => 360,
        10000 => 400,
        11000 => 440,
        12000 => 480,
        13000 => 520,
        14000 => 560,
        15000 => 600,
        16000 => 640,
        17000 => 680,
        18000 => 720,
        19000 => 760,
        20000 => 800,
    ];

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(InterpolateFeeProvider::class);
        $this->shouldBeAnInstanceOf(\PragmaGoTech\Interview\FeeCalculatorInterface::class);
    }

    public function it_should_returns_linear_interpolation_for_short_term_loan(LoanProposal $application): void
    {

        $this->calculate(new LoanProposal(12, 1001), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(50.04, 0.001);
        $this->calculate(new LoanProposal(12, 2750), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(90, 0.01);
        $this->calculate(new LoanProposal(12, 3892.98), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(112.3245, 0.00001);
        $this->calculate(new LoanProposal(12, 19999.99), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(399.9998, 0.00001);
        $this->calculate(new LoanProposal(12, 11111.11), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(222.2222, 0.00001);
        $this->calculate(new LoanProposal(12, 9000.00), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(180, 0.01);
        $this->calculate(new LoanProposal(12, 9000.01), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(180.0002, 0.00001);
        $this->calculate(new LoanProposal(12, 4827.63), self::SHORT_LOAN_FEE_TABLE)->shouldBeApproximately(102.58555, 0.000001);
    }

    public function it_should_returns_linear_interpolation_for_long_term_loan(): void
    {

        $this->calculate(new LoanProposal(12, 1001), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(70.03, 0.001);
        $this->calculate(new LoanProposal(12, 2750), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(115, 0.01);
        $this->calculate(new LoanProposal(12, 3892.98), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(155.7192, 0.00001);
        $this->calculate(new LoanProposal(12, 19999.99), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(799.9996, 0.00001);
        $this->calculate(new LoanProposal(12, 11111.11), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(444.4444, 0.00001);
        $this->calculate(new LoanProposal(12, 9000.00), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(360, 0.01);
        $this->calculate(new LoanProposal(12, 9000.01), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(360.0004, 0.00001);
        $this->calculate(new LoanProposal(12, 4827.63), self::LONG_LOAN_FEE_TABLE)->shouldBeApproximately(193.1052, 0.000001);
    }



    public function it_should_point_closest_lower_key()
    {
        $this->calculateClosestLower(2100, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(2000);
        $this->calculateClosestLower(8742, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(8000);
        $this->calculateClosestLower(9999.99, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(9000);
        $this->calculateClosestLower(15000, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(15000);
        $this->calculateClosestLower(18523.65489, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(18000);

        $this->calculateClosestLower(2100, self::LONG_LOAN_FEE_TABLE)->shouldReturn(2000);
        $this->calculateClosestLower(8742, self::LONG_LOAN_FEE_TABLE)->shouldReturn(8000);
        $this->calculateClosestLower(9999.99, self::LONG_LOAN_FEE_TABLE)->shouldReturn(9000);
        $this->calculateClosestLower(15000, self::LONG_LOAN_FEE_TABLE)->shouldReturn(15000);
        $this->calculateClosestLower(18523.65489, self::LONG_LOAN_FEE_TABLE)->shouldReturn(18000);
    }

    public function it_should_point_closest_higher_key()
    {
        $this->calculateClosestHigher(2100, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(3000);
        $this->calculateClosestHigher(8742, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(9000);
        $this->calculateClosestHigher(9999.99, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(10000);
        $this->calculateClosestHigher(15000, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(16000);
        $this->calculateClosestHigher(18523.65489, self::SHORT_LOAN_FEE_TABLE)->shouldReturn(19000);
        $this->calculateClosestHigher(2100, self::LONG_LOAN_FEE_TABLE)->shouldReturn(3000);
        $this->calculateClosestHigher(8742, self::LONG_LOAN_FEE_TABLE)->shouldReturn(9000);
        $this->calculateClosestHigher(9999.99, self::LONG_LOAN_FEE_TABLE)->shouldReturn(10000);
        $this->calculateClosestHigher(15000, self::LONG_LOAN_FEE_TABLE)->shouldReturn(16000);
        $this->calculateClosestHigher(18523.65489, self::LONG_LOAN_FEE_TABLE)->shouldReturn(19000);
    }
}
