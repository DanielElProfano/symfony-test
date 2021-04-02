<?php
namespace App\Model;

class Peliculas
{
    private $name;
    private $year;
    private $psinopsis;

    public function __construct(string $name, int $year, string $psinopsis)
    {
        $this->name = $name;
        $this->year = $year;
        $this->psinopsis = $psinopsis;
    }

        /**
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

        /**
         * Get the value of year
         */ 
        public function getYear()
        {
                return $this->year;
        }

        /**
         * Get the value of psinopsis
         */ 
        public function getPsinopsis()
        {
                return $this->psinopsis;
        }

       
}