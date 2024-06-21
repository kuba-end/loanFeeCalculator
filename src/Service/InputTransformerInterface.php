<?php

namespace PragmaGoTech\Interview\Service;

interface InputTransformerInterface
{
    public function truncateToDecimal(string $answer): string;
}