<?php

namespace App\Entity;

use App\Repository\CategoryItemRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryItemRepository::class)]
#[Vich\Uploadable]
class CategoryItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[Vich\UploadableField(mapping: 'category_picture', fileNameProperty: 'photo')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $photoFile = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[Vich\UploadableField(mapping: 'category_picture', fileNameProperty: 'logo')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $logoFile = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $updatedAt = null;


    #[ORM\OneToMany(mappedBy: 'categoryItem', targetEntity: Product::class, orphanRemoval: true)]
    private Collection $products;

    #[ORM\Column]
    private ?bool $inCarousel = false;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategoryItem($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategoryItem() === $this) {
                $product->setCategoryItem(null);
            }
        }

        return $this;
    }

    public function isInCarousel(): ?bool
    {
        return $this->inCarousel;
    }

    public function setInCarousel(bool $inCarousel): self
    {
        $this->inCarousel = $inCarousel;

        return $this;
    }

    public function setPhotoFile(File $image = null): CategoryItem
    {
        $this->photoFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function setLogoFile(File $image = null): CategoryItem
    {
        $this->logoFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): DateTimeInterface|null
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
