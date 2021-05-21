<?php

namespace App\Entity;

use App\Repository\VendeurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VendeurRepository::class)
 */
class Vendeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  /**
 * @ORM\Column(type="string", length=255)
 * @Assert\Length(
 * min = 5,
 * max = 50,
 * minMessage = "Le nom d'un Vendeur doit comporter au moins {{ limit }} caractères",
 * maxMessage = "Le nom d'un Vendeur doit comporter au plus {{ limit }} caractères"
 * )
 */

    private $Nom;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\NotEqualTo(
 * value = 0,
 * message = "Le salaire d’un vendeur ne doit pas être égal à 0 "
 * )
     */
    private $Salaire;

    /**
     * @ORM\ManyToOne(targetEntity=Magasin::class, inversedBy="vendeurs")
     */
    private $magasin;

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

    public function getSalaire(): ?string
    {
        return $this->Salaire;
    }

    public function setSalaire(string $Salaire): self
    {
        $this->Salaire = $Salaire;

        return $this;
    }

    public function getMagasin(): ?Magasin
    {
        return $this->magasin;
    }

    public function setMagasin(?Magasin $magasin): self
    {
        $this->magasin = $magasin;

        return $this;
    }
}
