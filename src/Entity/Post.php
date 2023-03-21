<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: SiteUser::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private $SiteUser;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $comment;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Photo::class, orphanRemoval: true)]
    private $photos;

    public function __toString() {

        return $this->SiteUser->getEmail() . "-" . $this->getId();
    }


    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteUser(): ?SiteUser
    {
        return $this->SiteUser;
    }

    public function setSiteUser(?SiteUser $SiteUser): self
    {
        $this->SiteUser = $SiteUser;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setPost($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPost() === $this) {
                $photo->setPost(null);
            }
        }

        return $this;
    }
}
