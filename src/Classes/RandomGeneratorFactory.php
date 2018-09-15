<?php

namespace App\Classes;

use App\Classes\Interfaces\RandomGeneratorInterface;

class RandomGeneratorFactory
{
    /**
     * @param string $class
     *
     * @return RandomGeneratorInterface
     */
    public static function createRandomGenerator(string $class): RandomGeneratorInterface
    {
        return new $class;
    }
}
