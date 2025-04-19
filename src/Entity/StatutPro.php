<?php

namespace App\Entity;

use App\Repository\StatutProRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutProRepository::class)]
class StatutPro {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	public ?string $label = null;

	#[ORM\Column]
	private ?int $ordre = null;

	#[ORM\ManyToOne(inversedBy: 'statutsPro')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Etat $etat = null;

	#[ORM\OneToMany(mappedBy: 'statut_professionnel', targetEntity: Membre::class)]
	private Collection $membres;

	public function __construct() {
		$this->membres = new ArrayCollection();
	}

	/*public function __toString(): string {
		return $this->getLabel();
	}*/


	public function getId(): ?int {
		return $this->id;
	}

	public function getLabel(): ?string {
		return $this->label;
	}

	public function setLabel(string $label): self {
		$this->label = $label;

		return $this;
	}

	public function getOrdre(): ?int {
		return $this->ordre;
	}

	public function setOrdre(int $ordre): self {
		$this->ordre = $ordre;

		return $this;
	}

	public function getEtat(): ?Etat {
		return $this->etat;
	}

	public function setEtat(?Etat $etat): self {
		$this->etat = $etat;

		return $this;
	}

	/**
	 * @return Collection<int, Membre>
	 */
	public function getMembres(): Collection {
		return $this->membres;
	}

	public function addMembre(Membre $membre): self {
		if (!$this->membres->contains($membre)) {
			$this->membres->add($membre);
			$membre->setStatutProfessionnel($this);
		}

		return $this;
	}

	public function removeMembre(Membre $membre): self {
		if ($this->membres->removeElement($membre)) {
			// set the owning side to null (unless already changed)
			if ($membre->getStatutProfessionnel() === $this) {
				$membre->setStatutProfessionnel(null);
			}
		}

		return $this;
	}
}
