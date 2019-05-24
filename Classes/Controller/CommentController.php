<?php
/**
 * Comment Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use ExtbaseBook\Simpleblog\Controller\AbstractBackendController;
use ExtbaseBook\Simpleblog\Domain\Repository\CommentRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Comment controller class
 */
class CommentController extends AbstractBackendController
{
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
        $this->commentRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * List all comments
     */
    public function listAction(): void
    {
        $comments = $this->commentRepository->findAll();
        $query = $comments->getQuery();
        $query->setOrderings(['commentdate' => QueryInterface::ORDER_DESCENDING]);
        $this->view->assign('comments', $query->execute());
    }
}
