<?php 
namespace App\Manager;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;

class PokemonManager
{
    public function getAllPokemons($em)
    {
        $repo = $em->getRepository(Pokemon::class);
        return $repo->findAll();
    }
}