<?php

declare(strict_types=1);

namespace spec\PragmaGoTech\Interview\Service;

use PhpSpec\ObjectBehavior;
use PragmaGoTech\Interview\Service\FeeCalculatorHelper;
use PragmaGoTech\Interview\Service\FeeCalculatorHelperInterface;

class FeeCalculatorHelperSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FeeCalculatorHelper::class);
        $this->shouldBeAnInstanceOf(FeeCalculatorHelperInterface::class);
    }
    public function it_should_round_up_sum_of_amount_and_fee_to_multipication_of_five()
    {
        $this->roundUpLoanAndFeeSum(70.03, 1001)->shouldBeApproximately(74, 0.01);
        $this->roundUpLoanAndFeeSum(115, 2750)->shouldBeApproximately(115, 0.01);
        $this->roundUpLoanAndFeeSum(155.7192, 3892.98)->shouldBeApproximately(157.02, 0.01);
        // Not so logic correct example where fee is higher for 19999.99 loan than for 20000 but fulfils expectation to
        // round up sum to 5 multiplier
        $this->roundUpLoanAndFeeSum(799.9996, 19999.99)->shouldBeApproximately(800.01, 0.01);
        $this->roundUpLoanAndFeeSum(444.4444, 11111.11)->shouldBeApproximately(448.89, 0.01);
        $this->roundUpLoanAndFeeSum(360, 9000.00)->shouldBeApproximately(360, 0.01);
        $this->roundUpLoanAndFeeSum(360.0004, 9000.01)->shouldBeApproximately(364.99, 0.01);
        $this->roundUpLoanAndFeeSum(193.1052, 4827.63)->shouldBeApproximately(197.37, 0.01);
    }
}
