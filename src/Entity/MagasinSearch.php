<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
class MagasinSearch
{
 /**
 * @ORM\ManyToOne(targetEntity="App\Entity\Magasin")
 */
 private $Magasin;
 public function getMagasin(): ?Magasin
 {
 return $this->Magasin;
 }
 public function setMagasin(?Magasin $Magasin): self
 {
 $this->Magasin = $Magasin;
 return $this;
 }
}
