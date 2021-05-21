<?php

namespace App\Entity;

use App\Repository\MagasinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MagasinRepository::class)
 */
class Magasin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="text")
     */
    private $Adresse;

    /**
     * @ORM\OneToMany(targetEntity=Vendeur::class, mappedBy="magasin")
     */
    private $vendeurs;

    public function __construct()
    {
        $this->vendeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    /**
     * @return Collection|vendeur[]
     */
    public function getVendeurs(): Collection
    {
        return $this->vendeurs;
    }

    public function addVendeur(vendeur $vendeur): self
    {
        if (!$this->vendeurs->contains($vendeur)) {
            $this->vendeurs[] = $vendeur;
            $vendeur->setMagasin($this);
        }

        return $this;
    }

    public function removeVendeur(vendeur $vendeur): self
    {
        if ($this->vendeurs->removeElement($vendeur)) {
            // set the owning side to null (unless already changed)
            if ($vendeur->getMagasin() === $this) {
                $vendeur->setMagasin(null);
            }
        }

        return $this;
    }
}
