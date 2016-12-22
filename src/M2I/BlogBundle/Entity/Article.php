<?php

namespace M2I\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use M2I\BlogBundle\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="M2I\BlogBundle\Repository\ArticleRepository")
 */
class Article
{
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createDate", type="datetimetz")
     */
    private $createDate;

    /**
     * @ORM\OneToOne(targetEntity="M2I\BlogBundle\Entity\Image", cascade={"persist"})
     */
    private $image;

    /**
    * One Article has Many Comments.
    * @ORM\OneToMany(targetEntity="M2I\BlogBundle\Entity\Comment", mappedBy="article")
    */
    private $commentList;

    public function __construct()
    {
        $this->createDate = new \DateTime();
        $this->commentList = new ArrayCollection();
    }

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
     * @return Article
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
     * Set description
     *
     * @param string $description
     * @return Article
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

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Article
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
     * Set image
     *
     * @param \M2I\BlogBundle\Entity\Article $image
     * @return Article
     */
    public function setImage(\M2I\BlogBundle\Entity\Article $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \M2I\BlogBundle\Entity\Article
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add commentList
     *
     * @param \M2I\BlogBundle\Entity\Comment $commentList
     * @return Article
     */
    public function addCommentList(\M2I\BlogBundle\Entity\Comment $commentList)
    {
        $this->commentList[] = $commentList;

        $commentList->setArticle($this);

        return $this;
    }

    /**
     * Remove commentList
     *
     * @param \M2I\BlogBundle\Entity\Comment $commentList
     */
    public function removeCommentList(\M2I\BlogBundle\Entity\Comment $commentList)
    {
        $this->commentList->removeElement($commentList);
    }

    /**
     * Get commentList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentList()
    {
        return $this->commentList;
    }
}
