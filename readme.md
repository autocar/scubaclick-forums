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

Notes
-----

Please note that ScubaClick Forums is not a plug and play package. It involves some setup. See below.

Service Provider
----------------

Add the following in app/config/app.php to the service providers array:
```php
'ScubaClick\Forums\ForumsServiceProvider',
```

Config
------

To change the configuration values, run the following command in the console:
```php
php artisan config:publish scubaclick/forums
```

Templates
---------

After publishing the config file, change the template array to point to the correct files. Within these files you can include the various sub-templates

```php
// listing of all forums
@include('forums::front.loops.forums')

// listing of a single forum and its topics
@include('forums::front.loops.topics')

// listing of a single topic and its replies
@include('forums::front.loops.replies')
```

Routes
------

A helper function has been included which can be used to load the forum routes where you need them, e.g.
```php
Route::group(['domain' => '{support}.domain.com''], function() {
    load_forum_routes();
});
```

Migrations
----------

To create the database tables, run the following command in the console:
```php
php artisan migrate --package="scubaclick/forums"
```

Assets
------

Run the following command to publish the frontend CSS file
```php
php artisan asset:publish --package="scubaclick/forums"
```

In case there are any CSS issues, pull requests should modify `compass/sass/forums.scss` rather than `public/css/forums.css`.

Capabilities
------------

Access to new topic and reply forms can be regulated by hooking into the `capable` model events for Forum and Topic. By default only logged in users can post.

```php
Forum::capable(function($model)
{
	return Auth::check();
});
```

Traits
------

There's also a trait for the user model included for PHP >= 5.4 (for lower versions the trait methods should just be copied across):
```php
use \ScubaClick\Forums\Traits\UserTrait
```

License
-------

ScubaClick Forums is licenced under the MIT license.
