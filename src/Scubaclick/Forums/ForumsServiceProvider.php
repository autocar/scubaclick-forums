<?php namespace ScubaClick\Forums;

use Illuminate\Support\ServiceProvider;

class ForumsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('scubaclick/forums');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\ForumsInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\ForumsRepository'
        );

        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\TopicsInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\TopicsRepository'
        );

        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\RepliesInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\RepliesRepository'
        );

        $this->app->bind(
            'ScubaClick\\Forums\\Contracts\\LabelsInterface',
            'ScubaClick\\Forums\\Repositories\\Eloquent\\LabelsRepository'
        );
	}
}
