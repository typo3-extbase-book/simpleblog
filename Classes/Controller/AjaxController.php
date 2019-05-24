<?php
/**
 * AJAX Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use \TYPO3\CMS\Extbase\Mvc\View\JsonView;
use \ExtbaseBook\Simpleblog\Domain\Model\Post;
use \ExtbaseBook\Simpleblog\Domain\Model\Comment;
use \ExtbaseBook\Simpleblog\Domain\Repository\PostRepository;

/**
 * AJAX controller class
 */
class AjaxController extends ActionController
{
    /**
     * Set the default view object to JSON view
     *
     * @var JsonView
     */
    protected $defaultViewObjectName = JsonView::class;

    /**
     * Post repository
     *
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * Import post repository by dependency injection
     *
     * @param PostRepository $postRepository
     */
    public function injectPostRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Add a comment by updating post in the post repository.

     * @param Post $post
     * @param Comment $comment
     */
    public function commentAction(Post $post, Comment $comment = null)
    {
        // Do not persist, if comment is empty
        if ($comment->getComment() == "") {
            return false;
        }

        // Set date/time of comment and add comment to the Post
        $comment->setCommentdate(new \DateTime());
        $post->addComment($comment);
        $this->postRepository->update($post);
        $this->objectManager->get(PersistenceManager::class)->persistAll();

        $this->view->assign('comments', $post->getComments());
        $this->view->setConfiguration([
            'comments' => [
                '_descendAll' => [
                    '_only' => ['comment', 'commentdate'],
                    '_descend' => [
                        'commentdate' => []
                    ]
                ]
            ]
        ]);
        $this->view->setVariablesToRender(['comments']);
    }
}
