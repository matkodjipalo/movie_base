<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 * @ORM\Table(name="movie", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="tile_release_year_unique", columns={"title", "release_year"})
 * })
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="CastAndCrew", mappedBy="movie", cascade={"remove"})
     */
    private $castAndCrew;

    /**
     * @ORM\Column(type="string", length=175)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $releaseYear;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set releaseYear
     *
     * @param integer $releaseYear
     *
     * @return Movie
     */
    public function setReleaseYear($releaseYear)
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * Get releaseYear
     *
     * @return integer
     */
    public function getReleaseYear()
    {
        return $this->releaseYear;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Movie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
