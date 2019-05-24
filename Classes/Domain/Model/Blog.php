<?php
/**
 * Blog Domain Model
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use ExtbaseBook\Simpleblog\Domain\Model\Post;

/**
 * Domain Model: Blog
 */
class Blog extends AbstractEntity
{
    /**
     * Blog title
     *
     * @var string
     * @Validate("NotEmpty")
     * @Validate("ExtbaseBook\Simpleblog\Validation\Validator\WordCountValidator", options={"maximum": 10})
     */
    protected $title = '';

    /**
     * Description of the Blog
     *
     * @var string
     */
    protected $description = '';

    /**
     * Image of the Blog
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image;

    /**
     * Blog posts
     *
     * @var TYPO3\CMS\Extbase\Persistence\ObjectStorage<ExtbaseBook\Simpleblog\Domain\Model\Post>
     * @cascade remove
     * @lazy
     */
    protected $posts = null;

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
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
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
        $this->posts = new ObjectStorage();
    }

    /**
     * Adds a Post
     *
     * @param \ExtbaseBook\Simpleblog\Domain\Model\Post $post
     * @return void
     */
    public function addPost(Post $post)
    {
        $this->posts->attach($post);
    }

    /**
     * Removes a Post
     *
     * @param Post $postToRemove The Post to be removed
     * @return void
     */
    public function removePost(Post $postToRemove)
    {
        $this->posts->detach($postToRemove);
    }

    /**
     * Returns the posts
     *
     * @return ObjectStorage<Post> $posts
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Sets the posts
     *
     * @param ObjectStorage<Post> $posts
     * @return void
     */
    public function setPosts(ObjectStorage $posts)
    {
        $this->posts = $posts;
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
