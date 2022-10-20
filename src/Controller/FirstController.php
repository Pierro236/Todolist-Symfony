<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first/{name}/{firstname}', name: 'first')]
    public function bonjour($name, $firstname): Response
    {
        return $this->render('first/index.html.twig', [
            'name' => $name,
            'firstname' => $firstname
        ]);
    }
}
