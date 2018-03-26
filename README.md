# Base Path Middleware for PHP

This middleware just removes a prefix from the request uri. 

## Installation

This middleware can be installed with composer.

```bash
$ composer require los/basepath
```

## Usage

Just add the middleware as one of the first in your application.

For example:
```php
$app->pipe(new \LosMiddleware\BasePath\BasePath('/site'));
```

Every request with `/site` prefix will be replaced:
```
/site => /
/site/blog => /blog
/site/contact-us => /contact-us
```

### Zend Expressive

If you are using [expressive-skeleton](https://github.com/zendframework/zend-expressive-skeleton), you can copy `config/los-basepath.global.php.dist` to `config/autoload/los-basepath.global.php` and modify configuration as your needs.

#### Zend Expressive v3

Since version 3 of Zend Expressive you need to add the following to your `pipeline.php` instead of the example above:

```php
use LosMiddleware\BasePath\BasePath;
use Zend\Diactoros\Response;

$app->pipe(\Zend\Stratigility\doublePassMiddleware(new BasePath(), new Response()));
```

#### UrlHelper

Zend Expressive comes with a UrlHelper that generates a url for your application, but we need to inject the new basePath.

This modules comes with a UrlHelperFactory that does this job for you. Just add the following configuration:
```php
'dependencies' => [
    'factories' => [
        Zend\Expressive\Helper\UrlHelper::class => LosMiddleware\BasePath\UrlHelperFactory::class,
        /* ... */
    ],
],
``` 
