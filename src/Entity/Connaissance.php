<?php

namespace App\Entity;

use App\Repository\ConnaissanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnaissanceRepository::class)]
class Connaissance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $label = null;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $synonymes;

    #[ORM\ManyToMany(targetEntity: Membre::class, mappedBy: 'connaissances')]
    private Collection $membres;

    #[ORM\ManyToOne(inversedBy: 'connaissances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    public function __construct()
    {
        $this->synonymes = new ArrayCollection();
        $this->membres = new ArrayCollection();
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
     * @return Collection<int, self>
     */
    public function getSynonymes(): Collection
    {
        return $this->synonymes;
    }

    public function addSynonyme(self $synonyme): self
    {
        if (!$this->synonymes->contains($synonyme)) {
            $this->synonymes->add($synonyme);
        }

        return $this;
    }

    public function removeSynonyme(self $synonyme): self
    {
        $this->synonymes->removeElement($synonyme);

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->addConnaissance($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            $membre->removeConnaissance($this);
        }

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
