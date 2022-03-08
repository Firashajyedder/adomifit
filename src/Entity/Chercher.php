<?php 
  namespace App\Entity;
  class Chercher 
  {
     private $titre;

     
   public function getTitre(): ?string
   {
       return $this->titre;
   }

   public function setTitre(string $titre): self
   {
       $this->titre = $titre;

       return $this;
   }

  }
 ?>