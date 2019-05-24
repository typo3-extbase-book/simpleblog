<?php
/**
 * Post Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Context\Context;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use \ExtbaseBook\Simpleblog\Domain\Model\Blog;
use \ExtbaseBook\Simpleblog\Domain\Model\Post;
use \ExtbaseBook\Simpleblog\Domain\Model\Comment;
use \ExtbaseBook\Simpleblog\Domain\Repository\BlogRepository;
use \ExtbaseBook\Simpleblog\Domain\Repository\PostRepository;
use \ExtbaseBook\Simpleblog\Domain\Repository\TagRepository;
use \ExtbaseBook\Simpleblog\Domain\Repository\AuthorRepository;

/**
 * Post controller class
 */
class PostController extends ActionController
{
    /**
     * Post repository
     *
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * Import Post repository by dependency injection
     *
     * @param PostRepository $postRepository
     */
    public function injectBlogRepository(PostRepository $postRepository): void
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Initialize action
     */
    public function initializeAction(): void
    {
        $action = $this->request->getControllerActionName();
        if ($action !== 'show' && $action !== 'ajax') {
            $context = GeneralUtility::makeInstance(Context::class);
            if (!$context->getPropertyFromAspect('frontend.user', 'isLoggedIn')) {
                $this->redirect(null, null, null, null, $this->settings['loginpage']);
            }
        }
    }

    /**
     * To prevent exception #1297759968 ("It is not allowed to map property 'tags'"),
     * mapping of property "tags" is explicitly enabled by this method.
     *
     * Note: This is not documented in the TYPO3 Extbase Book, because we assume, reads
     * have created tags via the backend already, so the exception is not triggered.
     */
    protected function initializeAddAction()
    {
        /** @var PropertyMappingConfiguration $propertyMappingConfiguration */
        $propertyMappingConfiguration = $this->arguments['post']->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->allowProperties('tags');
    }

    /**
     * Show form to add a new post
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function addFormAction(Blog $blog, Post $post = null): void
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
        $this->view->assign('tags', $this->objectManager->get(TagRepository::class)->findAll());
        $this->view->assign('authors', $this->objectManager->get(AuthorRepository::class)->findAll());
    }

    /**
     * Add a new post to the repository
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function addAction(Blog $blog, Post $post = null): void
    {
        $post->setAuthor(
            $this->objectManager->get(AuthorRepository::class)->findOneByUid(
                $GLOBALS['TSFE']->fe_user->user['uid']
            )
        );

        //$post->setPostdate(new \DateTime());
        $this->postRepository->add($post);
        $blog->addPost($post);
        $this->objectManager->get(BlogRepository::class)->update($blog);
        $this->redirect('show', 'Blog', null, ['blog' => $blog]);
    }

    /**
     * Show a single post (detail view)
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function showAction(Blog $blog, Post $post): void
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
    }

    /**
     * Prevent exception #1297759968 ("It is not allowed to map property 'tags'").
     * @see method initializeAddAction() above.
     */
    protected function initializeUpdateAction()
    {
        /** @var PropertyMappingConfiguration $propertyMappingConfiguration */
        $propertyMappingConfiguration = $this->arguments['post']->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->allowProperties('tags');
    }

    /**
     * Show form to update an existing post
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function updateFormAction(Blog $blog, Post $post)
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
        $this->view->assign('tags', $this->objectManager->get(TagRepository::class)->findAll());
    }

    /**
     * Update an existing post in the Post repository
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function updateAction(Blog $blog, Post $post)
    {
        $this->postRepository->update($post);
        $this->redirect('show', 'Blog', null, ['blog' => $blog]);
    }

    /**
     * Show confirmation form before deleting a post
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function deleteConfirmAction(Blog $blog, Post $post)
    {
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
    }

    /**
     * Delete a post from the Post repository
     *
     * @param Blog $blog
     * @param Post $post
     */
    public function deleteAction(Blog $blog, Post $post)
    {
        //$blog->removePost($post);
        //$this->objectManager->get(BlogRepository::class)->update($blog);
        $this->postRepository->remove($post);
        $this->redirect('show', 'Blog', null, ['blog' => $blog]);
    }
}
