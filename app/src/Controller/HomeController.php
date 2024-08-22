<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contracts\EmailServiceInterface;
use App\Form\CategorySelectionType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly EmailServiceInterface $emailService,
        private readonly UserRepository $userRepository,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/', name: 'send_emails')]
    public function sendEmails(Request $request): Response
    {
        $form = $this->createForm(CategorySelectionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $this->userRepository->findByCategories($form->get('categories')->getData()->toArray());
            $this->emailService->sendEmails($users, $form->get('message')->getData());

            $this->addFlash('success', $this->translator->trans('message.emails_send'));

            return $this->redirectToRoute('send_emails');
        }

        return $this->render('home/send_emails.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
