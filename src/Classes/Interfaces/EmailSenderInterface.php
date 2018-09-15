<?php

namespace App\Classes\Interfaces;

interface EmailSenderInterface
{
    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void;

    /**
     * @param string $from
     */
    public function setFrom(string $from): void;

    /**
     * @param $to
     */
    public function setTo($to): void;

    /**
     * @param string $body
     */
    public function setBody(string $body): void;
}