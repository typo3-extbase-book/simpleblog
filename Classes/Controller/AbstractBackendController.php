<?php
/**
 * Abstract Backend Controller
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\TemplateView;

/**
 * Abstract backend controller provides functions for all backend controllers
 */
class AbstractBackendController extends ActionController
{
    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * Backend Template Container
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * Translation shortcut
     *
     * @param $key
     * @param array|null $arguments
     * @return string|null
     */
    protected function translate($key, $arguments = null)
    {
        return LocalizationUtility::translate(
            $key,
            'simpleblog',
            $arguments
        );
    }

    /**
     * Resolve view and initialize the general view-variables extensionName,
     * controllerName and actionName based on the request object
     *
     * @return TemplateView
     */
    protected function resolveView(): BackendTemplateView
    {
        $view = parent::resolveView();
        $view->assignMultiple([
            'extensionName' => $this->request->getControllerExtensionName(),
            'controllerName' => $this->request->getControllerName(),
            'actionName' => $this->request->getControllerActionName()
        ]);
        return $view;
    }

    /**
     * Generates the action menu
     */
    protected function generateMenu()
    {
        $menuItems = [
            'dashboard' => [
                'controller' => 'Dashboard',
                'action' => 'index',
                'label' => $this->translate('backend.dashboard.index.headline')
            ],
            'comments' => [
                'controller' => 'Comment',
                'action' => 'list',
                'label' => $this->translate('backend.comment.list.headline')
            ]
        ];

        $menu = $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('SimpleblogModuleMenu');

        foreach ($menuItems as $menuItemConfig) {
            $isActive = false;
            if ($this->request->getControllerName() === $menuItemConfig['controller']) {
                if ($this->request->getControllerActionName() === $menuItemConfig['action']) {
                    $isActive = true;
                }
            }
            $menuItem = $menu->makeMenuItem()
                ->setTitle($menuItemConfig['label'])
                ->setHref($this->getHref($menuItemConfig['controller'], $menuItemConfig['action']))
                ->setActive($isActive);
            $menu->addMenuItem($menuItem);
        }

        $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
    }

    /**
     * Creates te URI for a backend action
     *
     * @param string $controller
     * @param string $action
     * @param array $parameters
     * @return string
     */
    protected function getHref($controller, $action, $parameters = [])
    {
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($this->request);
        return $uriBuilder->reset()->uriFor($action, $parameters, $controller);
    }
}
