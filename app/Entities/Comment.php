<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment entity representing a user's comment on a product.
 * 
 * @package App\Entities
 */
#[ORM\Entity()]
#[ORM\Table(name: "comments")]
class Comment
{
    /**
     * @var int|null The unique identifier of the comment.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    /**
     * @var User The user who made the comment.
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /**
     * @var Product The product that the comment is related to.
     */
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    /**
     * @var string The content of the comment.
     */
    #[ORM\Column(type: "text")]
    private string $comment;

    /**
     * Get the comment's ID.
     *
     * @return int|null The comment ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the user who made the comment.
     *
     * @return User The user who made the comment.
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set the user who made the comment.
     *
     * @param User $user The user to associate with the comment.
     * @return self The current Comment instance.
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the product associated with the comment.
     *
     * @return Product The product related to the comment.
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Set the product associated with the comment.
     *
     * @param Product $product The product to associate with the comment.
     * @return self The current Comment instance.
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get the content of the comment.
     *
     * @return string The content of the comment.
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set the content of the comment.
     *
     * @param string $comment The comment content.
     * @return self The current Comment instance.
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }
}
