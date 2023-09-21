<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields : ['email'], message : 'Cette email est déjà pris')]



class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message : "Veuillez renseigner une adresse Email.",
        groups : ['registration']
    )]
    #[Assert\Email(
        message : "Veuillez saisir une adresse Email VALIDE.",
        groups : ['registration']
    )]

    private $email;

    #[ORM\Column(type: 'string', length: 255)]

    #[Assert\NotBlank(
        message : 'Veuillez saisir votre prénom',
        groups : ['registration']
    )]

    #[Assert\Length(
        min:'2', max: '45', 
        minMessage : 'Votre prénom doit comporter au moins 2 caractères', 
        maxMessage : 'Votre prénom ne doit pas dépasser 45 caractères',
        groups : ['registration']
    )]

    private $username;

    #[ORM\Column(type: 'string', length: 255)]

    #[Assert\NotBlank(
        message : 'Veuillez saisir votre nom',
        groups : ['registration']
    )]

    #[Assert\Length(
        min:'2', max: '45', 
        minMessage : 'Votre nom doit comporter au moins 2 caractères', 
        maxMessage : 'Votre nom ne doit pas dépasser 45 caractères',
        groups : ['registration']
    )]

    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]

    #[Assert\EqualTo(
        propertyPath : 'password',
        message : 'Les mots de passes ne correspondent pas',
        groups : ['registration']
    )]

    #[Assert\Length(
        min : '8', 
        minMessage : 'Le mot de passe doit contenir au moins 8 caractères',
        groups : ['registration']
    )]

    #[Assert\Regex(
        pattern : '/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])[\S]+$/',
        message : 'Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.'
    )]

    #[Assert\NotBlank(
        message : 'Veuillez saisir un mot de passe',
        groups : ['registration']

    )]

    private $password;

    #[Assert\EqualTo(
        propertyPath : 'password',
        message : 'Les mots de passes ne correspondent pas',
        groups : ['registration']
        
    )]

    #[Assert\NotBlank(
        message : 'Veuillez confirmer votre mot de passe',
        groups : ['registration']
    )]

    public $confirm_password;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Events::class)]
    private Collection $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {

    }

   /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }
}