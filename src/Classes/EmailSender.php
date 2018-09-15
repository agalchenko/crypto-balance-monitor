<?php

namespace App\Classes;

use App\Classes\Interfaces\EmailSenderInterface;

class EmailSender implements EmailSenderInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var mixed
     */
    protected $to;

    /**
     * @var string
     */
    protected $body;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send()
    {
        $message = (new \Swift_Message())
            ->setSubject($this->subject)
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody($this->body);

        $this->mailer->send($message);
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to): void
    {
        $this->to = $to;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
