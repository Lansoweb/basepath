<?php
namespace LosMiddleware\BasePath;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Helper\UrlHelper;

final class BasePathMiddleware implements MiddlewareInterface
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
     * @param string $basePath
     * @param UrlHelper $urlHelper
     */
    public function __construct(string $basePath = '', UrlHelper $urlHelper = null)
    {
        $this->basePath = $basePath;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();

        $path = $uri->getPath();

        if (empty($this->basePath) || strpos($path, $this->basePath) !== 0) {
            return $handler->handle($request);
        }

        $path = substr($path, strlen($this->basePath)) ?: '/';

        $request = $request->withUri($uri->withPath($path));
        $request = $request->withAttribute(static::BASE_PATH, $this->basePath . $path);

        if ($this->urlHelper instanceof UrlHelper) {
            $this->urlHelper->setBasePath($this->basePath);
        }

        return $handler->handle($request);
    }
}
