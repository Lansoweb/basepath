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

        $path = $uri->getPath();

        if (empty($this->basePath) || strpos($path, $this->basePath) !== 0) {
            return $next($request, $response);
        }
        
        $path = substr($path, strlen($this->basePath)) ?: '/';
        
        $request = $request->withUri($uri->withPath($path));
        $request = $request->withAttribute(static::BASE_PATH, $this->basePath . $path);

        if ($this->urlHelper && !empty($this->basePath)) {
            $this->urlHelper->setBasePath($this->basePath);
        }

        return $next($request, $response);
    }

    /**
     * @param UrlHelper $urlHelper
     */
    public function setUrlHelper($urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

}
