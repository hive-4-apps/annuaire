<?php

	namespace App\Entity;

	use App\Enums\EtatEnum;
	use App\Repository\EtatRepository;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\Mapping as ORM;
	use PhpParser\Builder\Class_;

	#[ORM\Entity(repositoryClass: EtatRepository::class)]
	class Etat {
		#[ORM\Id]
		#[ORM\GeneratedValue]
		#[ORM\Column]
		private ?int $id = null;

		#[ORM\Column(length: 100)]
		private ?string $label = null;

		#[ORM\OneToMany(mappedBy: 'etat', targetEntity: StatutPro::class)]
		private Collection $statutsPro;

		#[ORM\OneToMany(mappedBy: 'etat', targetEntity: Membre::class, orphanRemoval: true)]
		private Collection $membres;

		#[ORM\OneToMany(mappedBy: 'etat', targetEntity: ActivitePro::class)]
		private Collection $activitePros;

		#[ORM\OneToMany(mappedBy: 'etat', targetEntity: CentreInteret::class)]
		private Collection $centreInterets;

		#[ORM\OneToMany(mappedBy: 'etat', targetEntity: Connaissance::class)]
		private Collection $connaissances;

		#[ORM\OneToMany(mappedBy: 'etat', targetEntity: PratiqueAsso::class)]
		private Collection $pratiqueAssos;

		public function __construct() {
			$this->statutsPro = new ArrayCollection();
			$this->membres = new ArrayCollection();
			$this->activitePros = new ArrayCollection();
			$this->centreInterets = new ArrayCollection();
			$this->connaissances = new ArrayCollection();
			$this->pratiqueAssos = new ArrayCollection();
		}

		public function __toString(): string {
			return $this->label ?? 'Inconnu';
		}

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

		/**
		 * @return Collection<int, StatutPro>
		 */
		public function getStatutsPro(): Collection {
			return $this->statutsPro;
		}

		public function addStatutsPro(StatutPro $statutsPro): self {
			if (!$this->statutsPro->contains($statutsPro)) {
				$this->statutsPro->add($statutsPro);
				$statutsPro->setEtat($this);
			}

			return $this;
		}

		public function removeStatutsPro(StatutPro $statutsPro): self {
			if ($this->statutsPro->removeElement($statutsPro)) {
				// set the owning side to null (unless already changed)
				if ($statutsPro->getEtat() === $this) {
					$statutsPro->setEtat(null);
				}
			}

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
				$membre->setEtat($this);
			}

			return $this;
		}

		public function removeMembre(Membre $membre): self {
			if ($this->membres->removeElement($membre)) {
				// set the owning side to null (unless already changed)
				if ($membre->getEtat() === $this) {
					$membre->setEtat(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection<int, ActivitePro>
		 */
		public function getActivitePros(): Collection {
			return $this->activitePros;
		}

		public function addActivitePro(ActivitePro $activitePro): self {
			if (!$this->activitePros->contains($activitePro)) {
				$this->activitePros->add($activitePro);
				$activitePro->setEtat($this);
			}

			return $this;
		}

		public function removeActivitePro(ActivitePro $activitePro): self {
			if ($this->activitePros->removeElement($activitePro)) {
				// set the owning side to null (unless already changed)
				if ($activitePro->getEtat() === $this) {
					$activitePro->setEtat(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection<int, CentreInteret>
		 */
		public function getCentreInterets(): Collection {
			return $this->centreInterets;
		}

		public function addCentreInteret(CentreInteret $centreInteret): self {
			if (!$this->centreInterets->contains($centreInteret)) {
				$this->centreInterets->add($centreInteret);
				$centreInteret->setEtat($this);
			}

			return $this;
		}

		public function removeCentreInteret(CentreInteret $centreInteret): self {
			if ($this->centreInterets->removeElement($centreInteret)) {
				// set the owning side to null (unless already changed)
				if ($centreInteret->getEtat() === $this) {
					$centreInteret->setEtat(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection<int, Connaissance>
		 */
		public function getConnaissances(): Collection {
			return $this->connaissances;
		}

		public function addConnaissance(Connaissance $connaissance): self {
			if (!$this->connaissances->contains($connaissance)) {
				$this->connaissances->add($connaissance);
				$connaissance->setEtat($this);
			}

			return $this;
		}

		public function removeConnaissance(Connaissance $connaissance): self {
			if ($this->connaissances->removeElement($connaissance)) {
				// set the owning side to null (unless already changed)
				if ($connaissance->getEtat() === $this) {
					$connaissance->setEtat(null);
				}
			}

			return $this;
		}

		/**
		 * @return Collection<int, PratiqueAsso>
		 */
		public function getPratiqueAssos(): Collection {
			return $this->pratiqueAssos;
		}

		public function addPratiqueAsso(PratiqueAsso $pratiqueAsso): self {
			if (!$this->pratiqueAssos->contains($pratiqueAsso)) {
				$this->pratiqueAssos->add($pratiqueAsso);
				$pratiqueAsso->setEtat($this);
			}

			return $this;
		}

		public function removePratiqueAsso(PratiqueAsso $pratiqueAsso): self {
			if ($this->pratiqueAssos->removeElement($pratiqueAsso)) {
				// set the owning side to null (unless already changed)
				if ($pratiqueAsso->getEtat() === $this) {
					$pratiqueAsso->setEtat(null);
				}
			}

			return $this;
		}
	}
