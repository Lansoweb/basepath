<?php
namespace LosMiddleware\BasePathTest;

use LosMiddleware\BasePath\BasePathMiddleware;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;

/**
 * BasePath test case.
 */
class BasePathMiddlewareTest extends TestCase
{
    private BasePathMiddleware $basePath;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        $this->basePath = new BasePathMiddleware('/basepath', null);
    }

    /**
     * @return string[][]
     */
    public function routeProvider(): array
    {
        return [
            ['', ''],
            ['/', '/'],
            ['/basepath', '/'],
            ['/basepath/', '/'],
            ['/basepath/test1', '/test1'],
        ];
    }

    /**
     * @dataProvider routeProvider
     */
    public function testCanHandleRoutes(string $route, string $expected): void
    {
        $request = new ServerRequest([], [], $route);
        $response = $this->basePath->process($request, new RequestHandler());
        $path = json_decode((string) $response->getBody(), true)['path'];
        $this->assertSame($expected, $path);
    }

}
