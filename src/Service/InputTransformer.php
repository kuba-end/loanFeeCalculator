<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service;

class InputTransformer implements InputTransformerInterface
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
}
