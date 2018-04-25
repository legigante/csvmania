<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $last_name;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $nb_failed_connexion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="created_by")
     */
    private $created_tasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="assigned_to")
     */
    private $assigned_tasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="validated_by")
     */
    private $validated_tasks;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->created_tasks = new ArrayCollection();
        $this->assigned_tasks = new ArrayCollection();
        $this->validated_tasks = new ArrayCollection();
    }

    public function getId()
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getNbFailedConnexion(): ?int
    {
        return $this->nb_failed_connexion;
    }

    public function setNbFailedConnexion(int $nb_failed_connexion): self
    {
        $this->nb_failed_connexion = $nb_failed_connexion;

        return $this;
    }
    public function addNbFailedConnexion(): self
    {
        $this->nb_failed_connexion++;

        return $this;
    }
    public function razNbFailedConnexion(): self
    {
        $this->nb_failed_connexion = 0;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getCreatedTasks(): Collection
    {
        return $this->created_tasks;
    }

    public function addCreatedTask(Task $createdTask): self
    {
        if (!$this->created_tasks->contains($createdTask)) {
            $this->created_tasks[] = $createdTask;
            $createdTask->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedTask(Task $createdTask): self
    {
        if ($this->created_tasks->contains($createdTask)) {
            $this->created_tasks->removeElement($createdTask);
            // set the owning side to null (unless already changed)
            if ($createdTask->getCreatedBy() === $this) {
                $createdTask->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getAssignedTasks(): Collection
    {
        return $this->assigned_tasks;
    }

    public function addAssignedTask(Task $assignedTask): self
    {
        if (!$this->assigned_tasks->contains($assignedTask)) {
            $this->assigned_tasks[] = $assignedTask;
            $assignedTask->setAssignedTo($this);
        }

        return $this;
    }

    public function removeAssignedTask(Task $assignedTask): self
    {
        if ($this->assigned_tasks->contains($assignedTask)) {
            $this->assigned_tasks->removeElement($assignedTask);
            // set the owning side to null (unless already changed)
            if ($assignedTask->getAssignedTo() === $this) {
                $assignedTask->setAssignedTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getValidatedTasks(): Collection
    {
        return $this->validated_tasks;
    }

    public function addValidatedTask(Task $validatedTask): self
    {
        if (!$this->validated_tasks->contains($validatedTask)) {
            $this->validated_tasks[] = $validatedTask;
            $validatedTask->setValidatedBy($this);
        }

        return $this;
    }

    public function removeValidatedTask(Task $validatedTask): self
    {
        if ($this->validated_tasks->contains($validatedTask)) {
            $this->validated_tasks->removeElement($validatedTask);
            // set the owning side to null (unless already changed)
            if ($validatedTask->getValidatedBy() === $this) {
                $validatedTask->setValidatedBy(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }




    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->active,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->active,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return ($this->nb_failed_connexion <= 3);
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->active;
    }


}
