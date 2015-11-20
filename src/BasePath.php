<?php
namespace LosMiddleware\BasePath;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class BasePath
{
    /**
     * @var string
     */
    private $basePath;

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
        if (! empty($this->basePath) && strpos($uri->getPath(), $this->basePath) === 0) {
            $path = substr($uri->getPath(), strlen($this->basePath)) ?: '';
            $request = $request->withUri($uri->withPath($path));
        }
        return $next($request, $response);
    }
}
