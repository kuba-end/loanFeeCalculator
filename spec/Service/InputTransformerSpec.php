<?php

declare(strict_types=1);

namespace spec\PragmaGoTech\Interview\Service;

use PhpSpec\ObjectBehavior;
use PragmaGoTech\Interview\Service\InputTransformer;
use PragmaGoTech\Interview\Service\InputTransformerInterface;

class InputTransformerSpec extends ObjectBehavior
{

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(InputTransformer::class);
        $this->shouldBeAnInstanceOf(InputTransformerInterface::class);
    }

    public function it_should_truncate_numeric_string_to_two_decimal(): void
    {
        $this->truncateToDecimal('986.9999')->shouldReturn('986.99');
        $this->truncateToDecimal('1000.123456789123456789')->shouldReturn('1000.12');
        $this->truncateToDecimal('19999.0165')->shouldReturn('19999.01');
        $this->truncateToDecimal('1986.9')->shouldReturn('1986.9');
        $this->truncateToDecimal('9865.')->shouldReturn('9865.');
    }

    public function it_should_handle_values_without_decimal(): void
    {
        $this->truncateToDecimal('986')->shouldReturn('986');
        $this->truncateToDecimal('1000')->shouldReturn('1000');
        $this->truncateToDecimal('20000')->shouldReturn('20000');
        $this->truncateToDecimal('10101')->shouldReturn('10101');
    }
}
