<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\EmailServiceInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class EmailService implements EmailServiceInterface
{
    public function __construct(
        private Environment $twig,
        private MailerInterface $mailer,
    ) {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws TransportExceptionInterface
     */
    public function sendEmails(array $users, string $message): void
    {
        foreach ($users as $user) {
            $email = (new Email())
                ->from('send@example.com')
                ->to($user->getEmail())
                ->subject('Hello Email')
                ->html(
                    $this->twig->render(
                        'emails/content.html.twig',
                        [
                            'firstName' => $user->getFirstName(),
                            'lastName' => $user->getLastName(),
                            'message' => $message,
                        ]
                    )
                );

            $this->mailer->send($email);
        }
    }
}
