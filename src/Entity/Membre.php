<?php

namespace App\Entity;

use App\Enums\EtatEnum;
use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    public ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    public ?string $nom = null;

    #[ORM\Column(length: 255)]
	public ?string $prenom = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'membres')]
	public ?StatutPro $statut_professionnel = null;

    #[ORM\Column(length: 255)]
	public ?string $email = null;

    #[ORM\ManyToMany(targetEntity: ActivitePro::class, inversedBy: 'membres')]
	public Collection $activites_pro;

    #[ORM\ManyToMany(targetEntity: CentreInteret::class, inversedBy: 'membres')]
	public Collection $centres_interets;

    #[ORM\ManyToMany(targetEntity: Connaissance::class, inversedBy: 'membres')]
	public Collection $connaissances;

    #[ORM\ManyToMany(targetEntity: PratiqueAsso::class, inversedBy: 'membres')]
	public Collection $pratiques_asso;

    #[ORM\Column(length: 255, nullable: true)]
	public ?string $lien_web = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    public ?Etat $etat = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'membres')]
    private ?Region $region = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'membres')]
    private ?Municipio $municipio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $reference = null;

    #[ORM\Column]
    private ?bool $termsAndConditions = null;

	public function __construct()
                         {
                     		$this->activites_pro = new ArrayCollection();
                             $this->centres_interets = new ArrayCollection();
                             $this->connaissances = new ArrayCollection();
                             $this->pratiques_asso = new ArrayCollection();
                         }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getStatutProfessionnel(): ?StatutPro
    {
        return $this->statut_professionnel;
    }

    public function setStatutProfessionnel(?StatutPro $statut_professionnel): self
    {
        $this->statut_professionnel = $statut_professionnel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, ActivitePro>
     */
    public function getActivitesPro(): Collection
    {
        return $this->activites_pro;
    }

    public function addActivitesPro(ActivitePro $activitesPro): self
    {
        if (!$this->activites_pro->contains($activitesPro)) {
            $this->activites_pro->add($activitesPro);
        }

        return $this;
    }

    public function removeActivitesPro(ActivitePro $activitesPro): self
    {
        $this->activites_pro->removeElement($activitesPro);

        return $this;
    }

    /**
     * @return Collection<int, CentreInteret>
     */
    public function getCentresInterets(): Collection
    {
        return $this->centres_interets;
    }

	public function getApprovedCentresInterets( EntityManagerInterface $em ): Collection
                     	{
                     		$all_centresInterets = $this->getCentresInterets();
                     		foreach( $all_centresInterets as $key_centre_interet => $centre_interet ){
                     			if( $centre_interet->getEtat() !== $em->getRepository(Etat::class)->getEtat(EtatEnum::APPROUVE)){
                     				$all_centresInterets->remove($key_centre_interet);
                     			}
                     		}
                     		return $all_centresInterets;
                     	}

    public function addCentresInteret(CentreInteret $centresInteret): self
    {
        if (!$this->centres_interets->contains($centresInteret)) {
            $this->centres_interets->add($centresInteret);
        }

        return $this;
    }

    public function removeCentresInteret(CentreInteret $centresInteret): self
    {
        $this->centres_interets->removeElement($centresInteret);

        return $this;
    }

    /**
     * @return Collection<int, Connaissance>
     */
    public function getConnaissances(): Collection
    {
		return $this->connaissances;
    }

	public function getApprovedConnaissances( EntityManagerInterface $em ): Collection
                         {
                     		$all_connaissances = $this->getConnaissances();
                     		foreach( $all_connaissances as $key_connaissance => $connaissance ){
                     			if( $connaissance->getEtat() !== $em->getRepository(Etat::class)->getEtat(EtatEnum::APPROUVE)){
                     				$all_connaissances->remove($key_connaissance);
                     			}
                     		}
                     		return $all_connaissances;
                         }

    public function addConnaissance(Connaissance $connaissance): self
    {
        if (!$this->connaissances->contains($connaissance)) {
            $this->connaissances->add($connaissance);
        }

        return $this;
    }

    public function removeConnaissance(Connaissance $connaissance): self
    {
        $this->connaissances->removeElement($connaissance);

        return $this;
    }

    /**
     * @return Collection<int, PratiqueAsso>
     */
    public function getPratiquesAsso(): Collection
    {
        return $this->pratiques_asso;
    }

	public function getApprovedPratiquesAsso( EntityManagerInterface $em ): Collection
                     	{
                     		$all_pratiquesAsso = $this->getPratiquesAsso();
                     		foreach( $all_pratiquesAsso as $key_pratique_asso => $pratique_asso ){
                     			if( $pratique_asso->getEtat() !== $em->getRepository(Etat::class)->getEtat(EtatEnum::APPROUVE)){
                     				$all_pratiquesAsso->remove($key_pratique_asso);
                     			}
                     		}
                     		return $all_pratiquesAsso;
                     	}

    public function addPratiquesAsso(PratiqueAsso $pratiquesAsso): self
    {
        if (!$this->pratiques_asso->contains($pratiquesAsso)) {
            $this->pratiques_asso->add($pratiquesAsso);
        }

        return $this;
    }

    public function removePratiquesAsso(PratiqueAsso $pratiquesAsso): self
    {
        $this->pratiques_asso->removeElement($pratiquesAsso);

        return $this;
    }

    public function getLienWeb(): ?string
    {
        return $this->lien_web;
    }

    public function setLienWeb(?string $lien_web): self
    {
        $this->lien_web = $lien_web;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getMunicipio(): ?Municipio
    {
        return $this->municipio;
    }

    public function setMunicipio(?Municipio $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getReference(): ?Uuid
    {
        return $this->reference;
    }

    public function setReference(Uuid $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function isTermsAndConditions(): ?bool
    {
        return $this->termsAndConditions;
    }

    public function setTermsAndConditions(bool $termsAndConditions): static
    {
        $this->termsAndConditions = $termsAndConditions;

        return $this;
    }
}
