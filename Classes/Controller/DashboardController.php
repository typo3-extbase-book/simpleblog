<?php
/**
 * Dashboard Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use ExtbaseBook\Simpleblog\Controller\AbstractBackendController;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use ExtbaseBook\Simpleblog\Domain\Repository\BlogRepository;
use ExtbaseBook\Simpleblog\Domain\Repository\PostRepository;
use ExtbaseBook\Simpleblog\Domain\Repository\CommentRepository;

/**
 * Dashboard controller class
 */
class DashboardController extends AbstractBackendController
{
    /**
     * Blog repository
     *
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * Import Blog repository by dependency injection
     *
     * @param BlogRepository $blogRepository
     */
    public function injectBlogRepository(BlogRepository $blogRepository): void
    {
         $this->blogRepository = $blogRepository;
    }

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
     * Comment repository
     *
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * Import comment repository by dependency injection
     *
     * @param CommentRepository $commentRepository
     */
    public function injectCommentRepository(CommentRepository $commentRepository): void
    {
         $this->commentRepository = $commentRepository;
    }

    /**
     * Initialize view
     *
     * @param ViewInterface
     */
    protected function initializeView(ViewInterface $view): void
    {
        if ($view instanceof BackendTemplateView) {
            /** @var BackendTemplateView $view */
            parent::initializeView($view);
            $this->generateMenu();
        }
    }

    /**
     * Initialize action
     */
    public function initializeAction(): void
    {
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $querySettings->setIgnoreEnableFields(true);
        $this->blogRepository->setDefaultQuerySettings($querySettings);
        $this->postRepository->setDefaultQuerySettings($querySettings);
        $this->commentRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * Index action
     */
    public function indexAction(): void
    {
        $this->view->assignMultiple([
            'numberOfBlogs' => $this->blogRepository->findAll()->count(),
            'numberOfPosts' => $this->postRepository->findAll()->count(),
            'numberOfComments' => $this->commentRepository->findAll()->count(),
            'lastBlogCreated' => $this->blogRepository->findLastRecordCreated()->getFirst(),
            'lastPostCreated' => $this->postRepository->findLastRecordCreated()->getFirst(),
            'lastCommentCreated' => $this->commentRepository->findLastRecordCreated()->getFirst()
        ]);
    }
}
