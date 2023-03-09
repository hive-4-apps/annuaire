<?php

namespace App\Entity;

use App\Repository\ActiviteProRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteProRepository::class)]
class ActivitePro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2)]
    private ?string $code_grand_domaine = null;

    #[ORM\Column(length: 255)]
    private ?string $appelation_grand_domaine = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $code_domaine = null;

    #[ORM\Column(length: 255)]
    private ?string $appelation_domaine = null;

    #[ORM\Column(nullable: true)]
    private ?int $code_ogr = null;

    #[ORM\Column(length: 255)]
    public ?string $appelation_metier = null;

    #[ORM\ManyToMany(targetEntity: Membre::class, mappedBy: 'activites_pro')]
    private Collection $membres;

    #[ORM\ManyToOne(inversedBy: 'activitePros')]
    private ?Etat $etat = null;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }

	public function __toString(): string {
		return $this->getAppelationMetier();
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeGrandDomaine(): ?string
    {
        return $this->code_grand_domaine;
    }

    public function setCodeGrandDomaine(string $code_grand_domaine): self
    {
        $this->code_grand_domaine = $code_grand_domaine;

        return $this;
    }

    public function getAppelationGrandDomaine(): ?string
    {
        return $this->appelation_grand_domaine;
    }

    public function setAppelationGrandDomaine(string $appelation_grand_domaine): self
    {
        $this->appelation_grand_domaine = $appelation_grand_domaine;

        return $this;
    }

    public function getCodeDomaine(): ?int
    {
        return $this->code_domaine;
    }

    public function setCodeDomaine(int $code_domaine): self
    {
        $this->code_domaine = $code_domaine;

        return $this;
    }

    public function getAppelationDomaine(): ?string
    {
        return $this->appelation_domaine;
    }

    public function setAppelationDomaine(string $appelation_domaine): self
    {
        $this->appelation_domaine = $appelation_domaine;

        return $this;
    }

    public function getCodeOgr(): ?int
    {
        return $this->code_ogr;
    }

    public function setCodeOgr(?int $code_ogr): self
    {
        $this->code_ogr = $code_ogr;

        return $this;
    }

    public function getAppelationMetier(): ?string
    {
        return $this->appelation_metier;
    }

    public function setAppelationMetier(string $appelation_metier): self
    {
        $this->appelation_metier = $appelation_metier;

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
            $membre->addActivitesPro($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            $membre->removeActivitesPro($this);
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
