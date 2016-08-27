<?php
namespace LosMiddleware\BasePathTest;

use LosMiddleware\BasePath\BasePath;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * BasePath test case.
 */
class BasePathTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BasePath
     */
    private $basePath;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->basePath = new BasePath('/basepath');
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
     * @dataProvider routeProvider
     */
    public function testCanHandleRoutes($route, $expected)
    {
        $response = $this->basePath->__invoke(new ServerRequest([], [], $route), new Response(), function(ServerRequest $request) {
            return $request->getUri()->getPath();
        });
        $this->assertSame($expected, $response);
    }

}

