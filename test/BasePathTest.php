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

    /**
     * @var BasePathMiddleware
     */
    private $basePath;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->basePath = new BasePathMiddleware('/basepath');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->basePath = null;
        parent::tearDown();
    }

    public function routeProvider()
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
     * @param $route
     * @param $expected
     * @dataProvider routeProvider
     */
    public function testCanHandleRoutes($route, $expected)
    {
        $request = new ServerRequest([], [], $route);
        $response = $this->basePath->process($request, new RequestHandler());
        $path = json_decode((string) $response->getBody(), true)['path'];
        $this->assertSame($expected, $path);
    }

}
