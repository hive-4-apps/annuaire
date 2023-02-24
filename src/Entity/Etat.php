<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: StatutPro::class)]
    private Collection $statutsPro;

    public function __construct()
    {
        $this->statutsPro = new ArrayCollection();
    }

		public function __toString(): string
		{
			return $this->label;
		}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, StatutPro>
     */
    public function getStatutsPro(): Collection
    {
        return $this->statutsPro;
    }

    public function addStatutsPro(StatutPro $statutsPro): self
    {
        if (!$this->statutsPro->contains($statutsPro)) {
            $this->statutsPro->add($statutsPro);
            $statutsPro->setEtat($this);
        }

        return $this;
    }

    public function removeStatutsPro(StatutPro $statutsPro): self
    {
        if ($this->statutsPro->removeElement($statutsPro)) {
            // set the owning side to null (unless already changed)
            if ($statutsPro->getEtat() === $this) {
                $statutsPro->setEtat(null);
            }
        }

        return $this;
    }
}
