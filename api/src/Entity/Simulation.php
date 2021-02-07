<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PostSimulation;
use App\Repository\SimulationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SimulationRepository::class)
 * @ApiResource(
 *     denormalizationContext={"groups"={"simulation:write"}},
 *     normalizationContext={"groups"={"simulation:read"}},
 *     collectionOperations={
 *          "post"={
 *              "controller"=PostSimulation::class
 *            },
 *          "get"={"security"="is_granted('ROLE_ADMIN') or object.owner == user"}

 *     },
 *     itemOperations={
 *          "get",
 *          "put"={
 *              "controller"=PostSimulation::class,
 *              "security"="is_granted('ROLE_ADMIN') or object.owner == user"
 *          }
 *     },
 *     shortName="simulation"
 * )
 */
class Simulation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"simulation:read", "simulation:write"})
     */
    private $concernedYear;

    /**
     * @ORM\Column(type="float")
     * @Groups({"simulation:read", "simulation:write"})
     */
    private $familyQuotient;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"simulation:read", "simulation:write"})
     */
    private $shareNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"simulation:read"})
     */
    private $tax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"simulation:read", "simulation:write"})
     */
    private $netIncome;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"simulation:read", "simulation:write"})
     */
    private $netIncomeSpouse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Groups({"simulation:read", "simulation:write"})
     *
     * @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *             "enum"={"FABIBLE", "FORT", "NULLE"},
     *             "example"="NULLE"
     *         }
     *     }
     * )
     */
    private $trend;

    /**
     * @ORM\Column
     * @Groups({"simulation:read", "user:read"})
     */
    private ?int $totalIncome;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Groups({"simulation:read", "simulation:write"})
     */
    private bool $isSingle = true;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"simulation:read", "simulation:write"})
     */
    private int $childrenNumber = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="simulations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getConcernedYear(): ?int
    {
        return $this->concernedYear;
    }

    public function setConcernedYear(int $concernedYear): self
    {
        $this->concernedYear = $concernedYear;

        return $this;
    }

    public function getFamilyQuotient(): ?float
    {
        return $this->familyQuotient;
    }

    public function setFamilyQuotient(float $familyQuotient): self
    {
        $this->familyQuotient = $familyQuotient;

        return $this;
    }

    public function getShareNumber(): ?float
    {
        return $this->shareNumber;
    }

    public function setShareNumber(?float $shareNumber): self
    {
        $this->shareNumber = $shareNumber;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(?int $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getNetIncome(): ?int
    {
        return $this->netIncome;
    }

    public function setNetIncome(?int $netIncome): self
    {
        $this->netIncome = $netIncome;

        return $this;
    }

    public function getNetIncomeSpouse(): ?int
    {
        return $this->netIncomeSpouse;
    }

    public function setNetIncomeSpouse(?int $netIncomeSpouse): self
    {
        $this->netIncomeSpouse = $netIncomeSpouse;

        return $this;
    }

    public function getTrend(): ?string
    {
        return $this->trend;
    }

    public function setTrend(?string $trend): self
    {
        $this->trend = $trend;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTotalIncome(): ?int
    {
        return $this->totalIncome;
    }

    public function setTotalIncome(?int $totalIncome): void
    {
        $this->totalIncome = $totalIncome;
    }

    public function getIsSingle(): bool
    {
        return $this->isSingle;
    }

    public function setIsSingle(?bool $isSingle): self
    {
        $this->isSingle = $isSingle;

        return $this;
    }

    public function getChildrenNumber(): int
    {
        return $this->childrenNumber;
    }

    public function setChildrenNumber(int $childrenNumber): self
    {
        $this->childrenNumber = $childrenNumber;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
