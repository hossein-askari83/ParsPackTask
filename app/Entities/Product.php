<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Product entity representing a product in the system.
 * 
 * @package App\Entities
 */
#[ORM\Entity()]
#[ORM\Table(name: "products")]
class Product
{
    /**
     * @var int|null The unique identifier of the product.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    #[Groups('basic')]

    private ?int $id = null;

    /**
     * @var string The name of the product.
     */
    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Groups('basic')]

    private string $name;

    /**
     * @var Collection<int, Comment> A collection of comments associated with this product.
     */
    #[ORM\OneToMany(mappedBy: "product", targetEntity: Comment::class, cascade: ["persist", "remove"], fetch: "EAGER")]
    #[Groups('with-comments')]
    private Collection $comments;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Get the product's ID.
     *
     * @return int|null The product ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the product's name.
     *
     * @return string The product name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the product's name.
     *
     * @param string $name The name of the product.
     * @return self The current Product instance.
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the comments associated with the product.
     *
     * @return Collection<int, Comment> The comments related to the product.
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

   /**
     * Set the comments associated with the product.
     *
     * @param Collection<int, Comment> $comments The new collection of comments.
     * @return self The current Product instance.
     */
    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;

        foreach ($comments as $comment) {
            $comment->setProduct($this);
        }

        return $this;
    }
}
