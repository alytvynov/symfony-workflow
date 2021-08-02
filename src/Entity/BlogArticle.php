<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog_article")
 */
class BlogArticle
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $title;

    private string $currentPlace;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $content;

    public function __construct()
    {
        $this->currentPlace = 'draft';
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return BlogArticle
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @param array  $context
     *
     * @return BlogArticle
     */
    public function setContent(string $content, array $context = []): self
    {
        $this->content = $content;

        return $this;
    }

    // getter/setter methods must exist for property access by the marking store
    public function getCurrentPlace()
    {
        return $this->currentPlace;
    }

    public function setCurrentPlace($currentPlace, $context = [])
    {
        $this->currentPlace = $currentPlace;
    }
}
