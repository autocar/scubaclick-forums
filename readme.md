ScubaClick Forums
=================

Add a forum to Laravel 4.
Still being developed for [ScubaClick](http://scubaclick.com), so handle with care for now!

Stable Version
--------------
v1.0

General Installation
--------------------

Install by adding the following to the require block in composer.json:
```
"scubaclick/forums": "dev-master"
```

Then run `composer update`.

Laravel-specific Installation
-----------------------------

Add the following in app/config/app.php to the service providers array:
```php
'ScubaClick\Forums\ForumsServiceProvider',
```

To change the configuration values, run the following command in the console:
```php
php artisan config:publish scubaclick/forums
```

Notes
-----

Please note that ScubaClick Forums does not provide any controllers, just the models, sub-views, migrations and repositories. You will have to implement all controllers yourself.

License
-------

ScubaClick Forums is licenced under the MIT license.
