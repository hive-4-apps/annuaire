<?php

namespace App\Entity;

use App\Repository\MunicipioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MunicipioRepository::class)]
class Municipio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codigo_ibge = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $longitude = null;

    #[ORM\OneToMany(mappedBy: 'municipio', targetEntity: Membre::class)]
    private Collection $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }

	public function __toString(): string
	{
		return $this->getNome() ?? 'Inconnu';
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoIbge(): ?int
    {
        return $this->codigo_ibge;
    }

    public function setCodigoIbge(int $codigo_ibge): self
    {
        $this->codigo_ibge = $codigo_ibge;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

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
            $membre->setMunicipio($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getMunicipio() === $this) {
                $membre->setMunicipio(null);
            }
        }

        return $this;
    }
}
