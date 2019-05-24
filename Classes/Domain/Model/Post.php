<?php
/**
 * Post Domain Model
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Domain Model: Post
 */
class Post extends AbstractEntity
{
    /**
     * Title of the post
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * Content of the post
     *
     * @var string
     */
    protected $content = '';

    /**
     * Post date/time
     *
     * @var \DateTime
     */
    protected $postdate = null;

    /**
     * Post comments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ExtbaseBook\Simpleblog\Domain\Model\Comment>
     * @cascade remove
     * @lazy
     */
    protected $comments = null;

    /**
     * Post author
     *
     * @var \ExtbaseBook\Simpleblog\Domain\Model\Author
     */
    protected $author = null;

    /**
     * Post tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ExtbaseBook\Simpleblog\Domain\Model\Tag>
     */
    protected $tags = null;

    /**
     * Creation timestamp
     *
     * @var int
     */
    protected $crdate;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Returns the postdate
     *
     * @return \DateTime $postdate
     */
    public function getPostdate()
    {
        return $this->postdate;
    }

    /**
     * Sets the postdate
     *
     * @param \DateTime $postdate
     * @return void
     */
    public function setPostdate(\DateTime $postdate)
    {
        $this->postdate = $postdate;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
        $this->setPostdate(new \DateTime());
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->comments = new ObjectStorage();
        $this->tags = new ObjectStorage();
    }

    /**
     * Adds a Comment
     *
     * @param \ExtbaseBook\Simpleblog\Domain\Model\Comment $comment
     * @return void
     */
    public function addComment(\ExtbaseBook\Simpleblog\Domain\Model\Comment $comment)
    {
        $this->comments->attach($comment);
    }

    /**
     * Removes a Comment
     *
     * @param \ExtbaseBook\Simpleblog\Domain\Model\Comment $commentToRemove The Comment to be removed
     * @return void
     */
    public function removeComment(\ExtbaseBook\Simpleblog\Domain\Model\Comment $commentToRemove)
    {
        $this->comments->detach($commentToRemove);
    }

    /**
     * Returns the comments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ExtbaseBook\Simpleblog\Domain\Model\Comment> $comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets the comments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ExtbaseBook\Simpleblog\Domain\Model\Comment> $comments
     * @return void
     */
    public function setComments(ObjectStorage $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Returns the author
     *
     * @return \ExtbaseBook\Simpleblog\Domain\Model\Author $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the author
     *
     * @param \ExtbaseBook\Simpleblog\Domain\Model\Author $author
     * @return void
     */
    public function setAuthor(\ExtbaseBook\Simpleblog\Domain\Model\Author $author)
    {
        $this->author = $author;
    }

    /**
     * Adds a Tag
     *
     * @param \ExtbaseBook\Simpleblog\Domain\Model\Tag $tag
     * @return void
     */
    public function addTag(\ExtbaseBook\Simpleblog\Domain\Model\Tag $tag)
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a Tag
     *
     * @param \ExtbaseBook\Simpleblog\Domain\Model\Tag $tagToRemove The Tag to be removed
     * @return void
     */
    public function removeTag(\ExtbaseBook\Simpleblog\Domain\Model\Tag $tagToRemove)
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * Returns the tags
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ExtbaseBook\Simpleblog\Domain\Model\Tag> $tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Sets the tags
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ExtbaseBook\Simpleblog\Domain\Model\Tag> $tags
     * @return void
     */
    public function setTags(ObjectStorage $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Returns the creation timestamp
     *
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }
}
