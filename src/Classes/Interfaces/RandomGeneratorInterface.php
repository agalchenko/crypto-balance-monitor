<?php

namespace App\Classes\Interfaces;

interface RandomGeneratorInterface
{
    /**
     * @param int $min
     * @param int $max
     *
     * @return string
     */
    public function generate(int $min, int $max): string;
}
