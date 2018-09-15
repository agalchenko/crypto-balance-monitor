<?php

namespace App\Classes;

use App\Classes\Interfaces\RandomGeneratorInterface;

class RandomDecimalGenerator implements RandomGeneratorInterface
{
    const COEFFICIENT = 1000;

    /**
     * {@inheritdoc}
     */
    public function generate(int $min, int $max): string
    {
        return mt_rand($min * self::COEFFICIENT, $max * self::COEFFICIENT) / self::COEFFICIENT;
    }
}
