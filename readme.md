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

To create the migrations, run the following command in the console:
```php
php artisan migrate --package="scubaclick/forums"
```

Run the following command to publish the frontend CSS file
```php
php artisan asset:publish --package="scubaclick/forums"
```

Traits
------

There's also a trait for the user model included for PHP >= 5.4 (for lower versions the trait methods should just be copied across):
```php
use \ScubaClick\Forums\Traits\UserTrait
```

Notes
-----

Please note that ScubaClick Forums does not provide any controllers, just the models, sub-views, migrations and repositories. You will have to implement the rest yourself.

License
-------

ScubaClick Forums is licenced under the MIT license.
