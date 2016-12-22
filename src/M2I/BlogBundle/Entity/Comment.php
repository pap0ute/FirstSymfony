<?php

namespace M2I\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use M2I\BlogBundle\Entity\Article;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="M2I\BlogBundle\Repository\CommentRepository")
 */
class Comment
{

    public function __construct()
    {
        $this->createDate = new \DateTime();
        //$this->commentList = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createDate", type="datetimetz")
     */
    private $createDate;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * Many Comments have One Article.
     * @ORM\ManyToOne(targetEntity="M2I\BlogBundle\Entity\Article", inversedBy="commentList")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
     private $article;

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
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Comment
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set article
     *
     * @param \M2I\BlogBundle\Entity\Article $article
     * @return Comment
     */
    public function setArticle(\M2I\BlogBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \M2I\BlogBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
