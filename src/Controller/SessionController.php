<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        // session_start()
        $connexion = array();
        $session = $request -> getSession();
        $pluriel = '';

        if($session -> has('nbVisite')){
            $nbreVisite = $session -> get('nbVisite') + 1;
            if($nbreVisite >= 2 ){
                $pluriel ='s';
            }
        } else{
            $id = $session -> getId();
            array_push($connexion, $id);
            $nbreVisite = 1;
        }
        $session ->set('nbVisite', $nbreVisite);


        return $this->render('session/index.html.twig', [
            'pluriel' => $pluriel,
        ]);
    }
}
