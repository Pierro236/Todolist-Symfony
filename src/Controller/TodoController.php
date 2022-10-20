<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use function mysql_xdevapi\getSession;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request -> getSession();
        if(!$session -> has('todos')){
           $todos = [
                'achat' => 'Acheter une ferrari',
                'cours' => 'Finaliser ma formation Symfony',
                'devoir' => 'Faire mes devoirs'
            ];

            $session -> set('todos',$todos);
            $this -> addFlash('info','Liste des todos initialisée ');
        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    #[Route('/add/{name}/{content}',
        name: 'todo.add',
        defaults:[
            'name' => 'default',
            'content' => 'no content'
        ],
    )]
    public function addTodo(Request $request, $name, $content):RedirectResponse {

        $session = $request -> getSession();

        // on vérifie si il existe un todo dans la session

        if($session -> has('todos')){
            $todos = $session -> get('todos');
            if(isset($todos[$name])){// si il existe déja j'affiche un erreur
                $this -> addFlash('error',"le todo $name est déja dans la liste");
            }
            else{
                //sinon je l'ajoute au tableau
                $todos = array($name => $content) + $todos;
                $session -> set('todos', $todos);
                $this -> addFlash('info',"Le todo $name à été ajoutée avec succès  ");
            }
        }
        else{
            $this -> addFlash('error',"La liste des todos n'a pas été initialisée ");
        }

        return $this-> redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content):RedirectResponse{

        $session = $request -> getSession();

        if($session -> has('todos')){
            $todos = $session -> get('todos');
            if(!isset($todos[$name])){
                $this -> addFlash('error',"Le todo $name n'existe pas ");
            }
            else{
                $todos[$name] = $content;
                $session -> set('todos', $todos);
                $this -> addFlash('info',"le todo $name a été modifié avec succès ");
            }

        }
        else{
            $this -> addFlash('error',"La liste des todos n'a pas été initialisée ");
        }

        return $this -> redirectToRoute('todo');
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name){

        $session = $request -> getSession();

        if($session -> has('todos')){
            $todos = $session -> get('todos');

            if(isset($todos[$name])){
                unset($todos[$name]);
                $session -> set('todos',$todos);
                $this -> addFlash('info',"le todo d'id $name a été supprimé avec succès ");
            }
            else{
                $this -> addFlash('error',"le todo d'id $name n'existe pas ");
            }
        }
        else{
            $this -> addFlash('error',"La liste des todos n'a pas été initialisée ");
        }

        return $this -> redirectToRoute('todo');
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request):RedirectResponse{

        $session = $request -> getSession();
        if($session -> has('todos')){
            $todos = [];
            $session -> set('todos', $todos);
        }
        return  $this->redirectToRoute('todo');
    }

}
