<?php

declare(strict_types=1);

namespace App\UI\Symfony\Controller;

use App\Application\Command\StartNewQuestCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $this->get('prooph_service_bus.app_command_bus')
            ->dispatch(StartNewQuestCommand::withData(
            "Workout",
            "Do a workout",
            2,
            ['A cookie']
        ));

        return $this->render('homepage.twig', []);
    }
}