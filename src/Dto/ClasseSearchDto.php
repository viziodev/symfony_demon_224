<?php

namespace App\Dto;

use App\Entity\Niveau;
use App\Entity\Filiere;

class ClasseSearchDto
{
    private ?Filiere $filiere = null;
    private ?Niveau $niveau = null;

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }
}
