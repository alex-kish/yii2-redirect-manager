# Yii 2 simple redirect manager

RedirectManager - if you need to redirect the user from one page to another.
Like UrlManager, but redirect.

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.4.

INSTALLATION
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):


```
composer require alex-kish/yii2-redirect-manager:"*"
```

CONFIGURATION
-------------

To use this extension, you have to configure the RedirectManager class in your application configuration:

```php
return [
    //....
    'bootstrap' => ['redirectManager'],
    //....
    'components' => [
        'redirectManager' => [
            'class' => alexKish\redirectManager\RedirectManager::class,
            'rules' => [
                '/from-1' => '/to-1',
                '/from-2' => '/to-2',
                [
                    'from' => '/from-3',
                    'to' => '/to-3',
                    'statusCode' => alexKish\redirectManager\RedirectRule::REDIRECT_STATUS_CODE_MOVED_TEMPORARILY
                ],
            ],
        ],
    ]
];
```