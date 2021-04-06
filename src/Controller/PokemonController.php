<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pokemon;
use App\Manager\PokemonManager;
use Cloudinary\Cloudinary;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
        $imageToUpload = $_FILES['imagen']['tmp_name'];
        $url = $this->uploadToCloud($imageToUpload);
        dd($url);
        $em->persist($pokemon);

        $em->flush();
        $allPokemons = $pokeManager->getAllPokemons($em);

        return $this->render('pokemon/showPokemonList.html.twig', ['pokemons' => $allPokemons]);
    }

    private function uploadToCloud($image)
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dcn1tgjkh',
                'api_key'    => '687241143766925',
                'api_secret' => 'qiQvSAItRFGW-y10LRzC4fdlXQs',
            ],
        ]);
        // $name = $image->tmp_name;

        $hola = $cloudinary->uploadApi()->upload($image);

        return $this->hola->storage->url;
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
        return $this->render('pokemon/showPokemonList.html.twig', ['pokemons' => $allPokemons]);
    }

    /**
     * @Route("/pokemon_list", name="pokemon_list")
     */

    public function pokemonList(
        EntityManagerInterface $em,
        PokemonManager $pokeManager,
        PaginatorInterface $paginator,
        Request $request
    ) {
        $pagination = $paginator->paginate(
            $pokeManager->getAllPokemons($em),
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('pokemon/showPokemonList.html.twig', ['pokemons' => $pagination]);
    }

    /**
     * @Route("/pokemon_modify/{id}", name="modify")
     */
    public function modifyPokemon($id, EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Pokemon::class);
        $pokemon = $repo->find($id);
        return $this->render('pokemon/editPokemon.html.twig', ['pokemon' => $pokemon]);
    }

    /**
     * @Route ("/savechanges/{id}", name="saveChanges")
     */
    public function saveChanges(
        $id,
        Request $request,
        EntityManagerInterface $em,
        PokemonManager $pokeManager
    ) {
        $repo = $em->getRepository(Pokemon::class);
        $pokemon = $repo->find($id);
        $pokemon->setDescription($request->request->get('description'));
        $pokemon->setName($request->request->get('name'));
        $em->flush();
        return $this->pokemonList($em, $pokeManager);
        // $allPokemons = $pokeManager->getAllPokemons($em);
        //return $this->render('pokemon/showPokemonList.html.twig', ['pokemons' => $allPokemons]);
    }
}
