<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Events\ClientRegisteredEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Email;

class ClientRegisterSubscriber implements EventSubscriberInterface
{
    public function onClientRegistered(ClientRegisteredEvent $event): void
    {
        $user = $event->getClient();

        // Create the email content using Twig template (or inline HTML)
        $emailContent = $this->twig->render('client/index.html.twig', [
            'user' => $user,
        ]);

        // Create the email
        $email = (new Email())
            ->from("viziodev03@gmail.com")
            ->to($user->getEmail())
            ->subject('Welcome to Our Service!')
            ->html($emailContent);

        // Send the email
        $this->mailer->send($email);
    }
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            ClientRegisteredEvent::NAME => 'onClientRegistered',
        ];
    }
}
