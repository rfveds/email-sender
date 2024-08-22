<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\CategorySelectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'send_emails')]
    public function sendEmails(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(CategorySelectionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->get('category')->getData();
            $users = $entityManager->getRepository(User::class)->createQueryBuilder('u')
                ->innerJoin('u.categories', 'c')
                ->where('c IN (:categories)')
                ->setParameter('categories', $category)
                ->getQuery()
                ->getResult();

            foreach ($users as $user) {
                $email = (new Email())
                    ->from('send@example.com')
                    ->to($user->getEmail())
                    ->subject('Hello Email')
                    ->html(
                        $this->renderView(
                            'emails/content.html.twig',
                            [
                                'firstName' => $user->getFirstName(),
                                'lastName' => $user->getLastName(),
                                'message' => $form->get('message')->getData(),
                            ]
                        )
                    );

                $mailer->send($email);
            }

            $this->addFlash('success', 'Emails sent successfully!');

            return $this->redirectToRoute('send_emails');
        }

        return $this->render('home/send_emails.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
