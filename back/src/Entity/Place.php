<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'place')]
    private Collection $booking;

    #[ORM\ManyToOne(inversedBy: 'place')]
    private ?Institution $institution = null;

    public function __construct()
    {
        $this->booking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $reservation): static
    {
        if (!$this->booking->contains($reservation)) {
            $this->booking->add($reservation);
            $reservation->setPlace($this);
        }

        return $this;
    }

    public function removeBooking(Booking $reservation): static
    {
        if ($this->booking->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getPlace() === $this) {
                $reservation->setPlace(null);
            }
        }

        return $this;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): static
    {
        $this->institution = $institution;

        return $this;
    }
}
