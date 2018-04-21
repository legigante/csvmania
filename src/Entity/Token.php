<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Task", inversedBy="tokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task_id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notif1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notif2;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notif3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_comment;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notif1_admin;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notif2_admin;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notif3_admin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_comment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $done_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validated_at;

    public function getId()
    {
        return $this->id;
    }

    public function getTaskId(): ?Task
    {
        return $this->task_id;
    }

    public function setTaskId(?Task $task_id): self
    {
        $this->task_id = $task_id;

        return $this;
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

    public function getNotif1(): ?string
    {
        return $this->notif1;
    }

    public function setNotif1(?string $notif1): self
    {
        $this->notif1 = $notif1;

        return $this;
    }

    public function getNotif2(): ?string
    {
        return $this->notif2;
    }

    public function setNotif2(?string $notif2): self
    {
        $this->notif2 = $notif2;

        return $this;
    }

    public function getNotif3(): ?string
    {
        return $this->notif3;
    }

    public function setNotif3(?string $notif3): self
    {
        $this->notif3 = $notif3;

        return $this;
    }

    public function getUserComment(): ?string
    {
        return $this->user_comment;
    }

    public function setUserComment(?string $user_comment): self
    {
        $this->user_comment = $user_comment;

        return $this;
    }

    public function getNotif1Admin(): ?string
    {
        return $this->notif1_admin;
    }

    public function setNotif1Admin(?string $notif1_admin): self
    {
        $this->notif1_admin = $notif1_admin;

        return $this;
    }

    public function getNotif2Admin(): ?string
    {
        return $this->notif2_admin;
    }

    public function setNotif2Admin(?string $notif2_admin): self
    {
        $this->notif2_admin = $notif2_admin;

        return $this;
    }

    public function getNotif3Admin(): ?string
    {
        return $this->notif3_admin;
    }

    public function setNotif3Admin(?string $notif3_admin): self
    {
        $this->notif3_admin = $notif3_admin;

        return $this;
    }

    public function getAdminComment(): ?string
    {
        return $this->admin_comment;
    }

    public function setAdminComment(?string $admin_comment): self
    {
        $this->admin_comment = $admin_comment;

        return $this;
    }

    public function getDoneAt(): ?\DateTimeInterface
    {
        return $this->done_at;
    }

    public function setDoneAt(?\DateTimeInterface $done_at): self
    {
        $this->done_at = $done_at;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validated_at;
    }

    public function setValidatedAt(?\DateTimeInterface $validated_at): self
    {
        $this->validated_at = $validated_at;

        return $this;
    }
}
