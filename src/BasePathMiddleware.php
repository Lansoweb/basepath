<?php

declare(strict_types=1);

namespace LosMiddleware\BasePath;

use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function strlen;
use function strpos;
use function substr;

final class BasePathMiddleware implements MiddlewareInterface
{
    public const BASE_PATH = 'los-basepath';

    private string $basePath;

    private ?UrlHelper $urlHelper;

    public function __construct(string $basePath, ?UrlHelper $urlHelper)
    {
        $this->basePath  = $basePath;
        $this->urlHelper = $urlHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();

        $path = $uri->getPath();

        if (empty($this->basePath) || strpos($path, $this->basePath) !== 0) {
            return $handler->handle($request);
        }

        $path = substr($path, strlen($this->basePath)) ?: '/';

        $request = $request->withUri($uri->withPath($path));
        $request = $request->withAttribute(self::BASE_PATH, $this->basePath . $path);

        if ($this->urlHelper instanceof UrlHelper) {
            $this->urlHelper->setBasePath($this->basePath);
        }

        return $handler->handle($request);
    }
}
