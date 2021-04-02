<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pokemon;
use App\Manager\PokemonManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PokemonController extends AbstractController
{

    /**
     * @Route ("/add_pokemon", name="pokemon")
     */
    public function add_pokemon(EntityManagerInterface $em, Request $request, PokemonManager $pokeManager): Response
    {
        
        $pokemon = new Pokemon();

        $pokemon->setName($request->request->get('name'));
        $pokemon->setDescription($request->request->get('type'));
        $pokemon->setImage($request->request->get('image'));
        $em->persist($pokemon);

        $em->flush();
        $allPokemons = $pokeManager->getAllPokemons($em);

        return $this->render('pokemon/showPokemonList.html.twig', ['pokemons'=>$allPokemons]);
    }

    /**
     * @Route ("/pokemonform")
     */

    public function pokemonForm(): Response
    {
        return $this->render('pokemon/pokemonform.html.twig');
    }

    /**
     * @Route("/pokemon_delete/{id}", name="delete")
     */
    public function delelePokemon($id, EntityManagerInterface $em, PokemonManager $pokeManager)
    {
        $repo = $em->getRepository(Pokemon::class);
        $pokemon = $repo->find($id);
        $em->remove($pokemon);
        $em->flush();
        $allPokemons = $pokeManager->getAllPokemons($em);
        return $this->render('pokemon/showPokemonList.html.twig', ['pokemons'=>$allPokemons]);

    }
}
