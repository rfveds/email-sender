<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\EmailService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EmailServiceTest extends TestCase
{
private $twig;
private $mailer;
private $emailService;

protected function setUp(): void
{
$this->twig = $this->createMock(Environment::class);
$this->mailer = $this->createMock(MailerInterface::class);
$this->emailService = new EmailService($this->twig, $this->mailer);
}

public function testSendEmails(): void
{
$users = [
$this->createUserMock('john.doe@example.com', 'John', 'Doe'),
$this->createUserMock('jane.doe@example.com', 'Jane', 'Doe')
];

$this->twig->method('render')
->willReturn('<p>Test message</p>');

$this->mailer->expects($this->exactly(2))
->method('send')
->with($this->isInstanceOf(Email::class));

$this->emailService->sendEmails($users, 'Test message');
}

private function createUserMock(string $email, string $firstName, string $lastName)
{
$user = $this->getMockBuilder(\stdClass::class)
->addMethods(['getEmail', 'getFirstName', 'getLastName'])
->getMock();

$user->method('getEmail')->willReturn($email);
$user->method('getFirstName')->willReturn($firstName);
$user->method('getLastName')->willReturn($lastName);

return $user;
}
}