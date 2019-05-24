<?php
/**
 * AJAX Dispatcher
 *
 * @package EXT:simpleblog
 * @author Michael Schams <michael@example.com>
 * @link https://www.extbase-book.org
 */

namespace ExtbaseBook\Simpleblog\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use ExtbaseBook\Simpleblog\BlogStatistics\Comments;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use GuzzleHttp\Psr7\Response;

/**
 * Implements the AJAX functionality for various asynchronous calls
 */
class AjaxDispatcher
{
    /**
     * Dispatch request
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $context = GeneralUtility::makeInstance(Context::class);
        if ($context->getPropertyFromAspect('backend.user', 'isAdmin') !== true) {
            $response = new Response();
            $response->getBody()->write('access denied');
            return $response
                ->withHeader('Content-Type', 'text/plain; charset=utf8')
                ->withStatus(403);
        }

        $data = [
            'lastComments' => Comments::countCommentsOfLastDays(),
            'postsPerBlog' => Comments::countPostsOfBlogs()
        ];
        return (new JsonResponse())->setPayload($data);
    }
}
