<?php

namespace App\Classes;

use App\Classes\Interfaces\RandomGeneratorInterface;

class RandomIntegerGenerator implements RandomGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate(int $min, int $max): string
    {
        return mt_rand($min, $max);
    }
}
