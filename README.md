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
$app->pipe(new \LosMiddleware\BasePath\BasePathMiddleware('/site'));
```

Every request with `/site` prefix will be replaced:
```
/site => /
/site/blog => /blog
/site/contact-us => /contact-us
```


### Mezzio (formerly Zend Expressive)

If you are using [mezzio-skeleton](https://github.com/mezzio/mezzio-skeleton), 
you can copy `config/los-basepath.global.php.dist` to `config/autoload/los-basepath.global.php` 
and modify configuration as your needs.

Then, add the middleware to your pipeline:
```php
$app->pipe(LosMiddleware\BasePath\BasePathMiddleware::class);
```

### Dynamic base path

In some cases a dynamic base path might be required. 
This can be achieved with the following code in your configuration file:

```php
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);

return [
    // Use directory of script path if available, otherwise default to empty string.
    'los' => [
        'basepath' => strlen($scriptPath) > 1 ? $scriptPath : '',
    ],
    
    // rest of the configuration ...
];
```
