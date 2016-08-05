<?php
namespace LosMiddleware\BasePath;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Helper\UrlHelper;

final class BasePath
{
    const BASE_PATH = 'los-basepath';

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var BasePathHelper
     */
    private $basePathHelper;

    /**
     * @param string $basePath
     */
    public function __construct($basePath = null)
    {
        $this->basePath = (string) $basePath;
    }

    /**
     * Runs the middleware
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $uri = $request->getUri();

        $path = $this->getBasePath($request);

        if (!empty($path)) {
            $request = $request->withUri($uri->withPath($path));
            $request = $request->withAttribute(static::BASE_PATH, $path);

            if ($this->urlHelper) {
                $this->urlHelper->setBasePath($path);
            }
        }

        return $next($request, $response);
    }

    /**
     * @param UrlHelper $urlHelper
     */
    public function setUrlHelper(UrlHelper $urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    private function getBasePath(RequestInterface $request)
    {
        $uri = $request->getUri();
        if (empty($this->basePath) || strpos($uri->getPath(), $this->basePath) !== 0) {
            return null;
        }
        return substr($uri->getPath(), strlen($this->basePath)) ?: '';
    }
}
