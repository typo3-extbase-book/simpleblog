<?php
/**
 * Comment Domain Model
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Domain Model: Comment
 */
class Comment extends AbstractEntity
{
    /**
     * Comment
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $comment = '';

    /**
     * commentdate
     *
     * @var \DateTime
     */
    protected $commentdate = null;

    /**
     * Creation timestamp
     *
     * @var int
     */
    protected $crdate;

    /**
     * Returns the comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the comment
     *
     * @param string $comment
     * @return void
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Returns the commentdate
     *
     * @return \DateTime $commentdate
     */
    public function getCommentdate()
    {
        return $this->commentdate;
    }

    /**
     * Sets the commentdate
     *
     * @param \DateTime $commentdate
     * @return void
     */
    public function setCommentdate(\DateTime $commentdate)
    {
        $this->commentdate = $commentdate;
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
