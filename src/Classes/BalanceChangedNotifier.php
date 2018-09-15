<?php

namespace App\Classes;

use App\Classes\Interfaces\EmailSenderInterface;
use App\Entity\Wallet;
use Symfony\Component\Templating\EngineInterface;

class BalanceChangedNotifier
{
    const SUBJECT = 'Your balance has been updated.';
    const SENDER = 'cryptoBalance@gmail.com';

    /**
     * @var EmailSenderInterface
     */
    protected $sender;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @param EmailSenderInterface $sender
     * @param EngineInterface $templating
     */
    public function __construct(EmailSenderInterface $sender, EngineInterface $templating)
    {
        $this->sender = $sender;
        $this->templating = $templating;
    }

    /**
     * @param Wallet $wallet
     * @param string $delta
     */
    public function notify(Wallet $wallet, string $delta)
    {
        $this->sender->setSubject(self::SUBJECT);
        $this->sender->setFrom(self::SENDER);
        $this->sender->setTo($wallet->getUser()->getEmail());
        $this->sender->setBody(
            $this->templating->render(
                'email/balanceChanged.html.twig',
                [
                    'wallet' => $wallet,
                    'newBalance' => $wallet->getBalance(),
                    'delta' => $delta,
                ]
            )
        );

        $this->sender->send();
    }
}
