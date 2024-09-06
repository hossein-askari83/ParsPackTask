<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Attribute\Groups;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User entity representing a registered user in the system.
 * 
 * @package App\Entities
 */
#[ORM\Entity()]
#[ORM\Table(name: "users")]
class User implements JWTSubject
{

    const USER_COMMENT_CONSTRAINTS = 2;

    /**
     * @var int|null The unique identifier of the user.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    #[Groups('basic')]

    private ?int $id = null;

    /**
     * @var string The username of the user, used for login.
     */
    #[ORM\Column(type: "string", length: 180, unique: true)]
    #[Groups('basic')]

    private string $username;

    /**
     * @var string The hashed password of the user.
     */
    #[ORM\Column(type: "string")]

    private string $password;

    /**
     * @var Collection<int, Comment> A collection of comments made by the user.
     */
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Comment::class, cascade: ["persist", "remove"])]
    #[Groups('with-comments')]

    private Collection $comments;

    /**
     * The salt used for password hashing.
     *
     * @var string
     */
    #[ORM\Column(type: "string")]
    private string $salt;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Get the user's id.
     *
     * @return int The id of the user.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the user's username.
     *
     * @return string The username of the user.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the user's username.
     *
     * @param string $username The username to set.
     * @return self The current User instance.
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get the user's password.
     *
     * @return string The hashed password.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the user's password.
     *
     * @param string $password The password to set.
     * @return self The current User instance.
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the salt.
     *
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * Set the salt.
     *
     * @param string $salt
     * @return self
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get the comments associated with the user.
     *
     * @return Collection<int, Comment> The user's comments.
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Get the JWT identifier for the user.
     *
     * This is typically the primary key of the user entity.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Set the comments associated with the user.
     *
     * @param Collection<int, Comment> $comments The new collection of comments.
     * @return self The current user instance.
     */
    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;

        foreach ($comments as $comment) {
            $comment->setUser($this);
        }

        return $this;
    }
}
