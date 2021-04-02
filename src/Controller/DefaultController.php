<?php

namespace App\Controller;

use App\Model\Peliculas;
use App\Model\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/home/{name}/{age}")
     */

    public function home($name, $age)
    {
        return $this->render('base.html.twig',
            [
                'name' => $name, 
                'age' => $age,
            ]);
    }

     /**
     * @Route("/post", name="filmes")
     */

    public function post()
    {
        $categorias = ['musical', 'accion','comedia','romántica'];
        $peliculas = $this->getPeliculas();
        return $this->render('post.html.twig', 
            [
                'films' => $peliculas
            ]);
    }

    /**
     * @Route ("/api")
     */

     public function api()
     {
         $peliculas = $this->getPeliculas();
         $arrayResponse = [];
         foreach($peliculas as $pelicula)
         {
             $dato = [
                 'name' => $pelicula->getName(),
                 'year' => $pelicula->getYear(),
             ];
             $arrayResponse [] = $dato;
         }
         return new JsonResponse($arrayResponse);
     }

    /**
     * @Route ("/peliculas/{id}")
     */
    public function peliculas ($id){

        echo ($id);
        $peliculas = $this->getPeliculas();
        return $this->render('detail.html.twig', ['film' => $peliculas[$id]]);
    }

    private function getPeliculas(): array
    {
        return [
            new Peliculas('mAtrix', 1999, "Eres el elegido...."),
            new Peliculas('Alien', 1989, "Va de un alienigena en una nave"),
        ];
    }
    /**
     * @Route("/")
     */

    public function index(){
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/calcula/{param}")
     */

    public function user($param)
    {
        if (is_numeric($param))
        {   
           
            if($param%2 != 0)
            {
                return new Response("el num, $param es impar");
            }
            else{
                return new Response("el num, $param es par");
            }
        }else{
            $array = str_split($param);
            $cadena = "";
            foreach($array as $clave => $letra)
            {
                if($clave%2 === 0){
                    $cadena .= strtoupper($letra);

                }else{
                    $cadena .= strtolower($letra);
                }
            }
            return new Response("$cadena");
        }
    }
}