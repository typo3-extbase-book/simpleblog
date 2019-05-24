<?php
/**
 * Blog Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use \TYPO3\CMS\Core\Messaging\AbstractMessage;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use \ExtbaseBook\Simpleblog\Domain\Model\Blog;
use \ExtbaseBook\Simpleblog\Domain\Repository\BlogRepository;
use \ExtbaseBook\Simpleblog\Property\TypeConverter\UploadedFileReferenceConverter;
use \TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;

/**
 * Blog controller class
 */
class BlogController extends ActionController
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
     * List Blogs
     *
     * @param string $search
     */
    public function listAction($search = ''): void
    {
        $search = '';
        if ($this->request->hasArgument('search')) {
            $search = $this->request->getArgument('search');
        }
        $limit = ($this->settings['blog']['max']) ?: null;
        $this->view->assign('blogs', $this->blogRepository->findSearchForm($search, 20));
        $this->view->assign('search', $search);
    }

    /**
     * Show form to add a new Blog
     *
     * @param Blog $blog
     */
    public function addFormAction(Blog $blog = null): void
    {
        $this->view->assign('blog', $blog);
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeAddAction(): void
    {
        $this->setTypeConverterConfigurationForImageUpload('blog');
    }

    /**
     * Add a new Blog to the Blog repository
     *
     * @param Blog $blog
     */
    public function addAction(Blog $blog): void
    {
        /*
        // Option 1
        $languageFile = 'LLL:EXT:simpleblog/Resources/Private/Language/locallang.xlf';
        $flashMessageHeadline = LocalizationUtility::translate(
            $languageFile . ':flashmessage.blog.blog-created.headline'
        );
        $flashMessageBody = LocalizationUtility::translate(
            $languageFile . ':flashmessage.blog.blog-created.body'
        );
        */

        // Option 2
        $flashMessageHeadline = LocalizationUtility::translate(
            'flashmessage.blog.blog-created.headline',
            'simpleblog'
        );
        $flashMessageBody = LocalizationUtility::translate(
            'flashmessage.blog.blog-created.body',
            'simpleblog'
        );

        $this->blogRepository->add($blog);
        $this->addFlashMessage(
            $flashMessageBody,
            $flashMessageHeadline,
            AbstractMessage::OK,
            true
        );
        $this->redirect('list');
    }

    /**
     * Show a single Blog (detail view)
     *
     * @param Blog $blog
     */
    public function showAction(Blog $blog): void
    {
        $this->view->assign('blog', $blog);
    }

    /**
     * Show form to update an existing Blog
     *
     * @param Blog $blog
     */
    public function updateFormAction(Blog $blog): void
    {
        $this->view->assign('blog', $blog);
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeUpdateAction(): void
    {
        $this->setTypeConverterConfigurationForImageUpload('blog');
    }

    /**
     * Update an existing Blog in the Blog repository
     *
     * @param Blog $blog
     */
    public function updateAction(Blog $blog): void
    {
        $this->blogRepository->update($blog);
        $this->redirect('list');
    }

    /**
     * Show confirmation form before deleting a Blog
     *
     * @param Blog $blog
     */
    public function deleteConfirmAction(Blog $blog)
    {
        $this->view->assign('blog', $blog);
    }

    /**
     * Delete a Blog from the Blog repository
     *
     * @param Blog $blog
     */
    public function deleteAction(Blog $blog): void
    {
        $this->blogRepository->remove($blog);
        $this->redirect('list');
    }

    /**
     * Set TypeConverter configuration for image upload
     *
     * @param string
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName): void
    {
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS =>
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER =>
                '1:/simpleblog/',
        ];
        /** @var PropertyMappingConfiguration $propertyMappingConfiguration */
        $propertyMappingConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->forProperty('image')
            ->setTypeConverterOptions(
                UploadedFileReferenceConverter::class,
                $uploadConfiguration
            );
    }
}
